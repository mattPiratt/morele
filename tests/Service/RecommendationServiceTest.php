<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Repository\MovieRepository;
use App\Service\Recommendation\Strategy\MultiWordTitlesStrategy;
use App\Service\Recommendation\Strategy\RandomThreeStrategy;
use App\Service\Recommendation\Strategy\StartingWithWEvenLengthStrategy;
use App\Service\RecommendationService;
use App\Tests\DataProvider\Service\RecommendationServiceDataProvider;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\TestCase;

class RecommendationServiceTest extends TestCase
{

    #[DataProviderExternal(RecommendationServiceDataProvider::class, 'getRandomThree')]
    public function testGetRandomThree($titles, $expectedCount): void
    {
        $service = $this->createService($titles);
        $result = $service->getRecommendations(RandomThreeStrategy::NAME);

        $this->assertCount($expectedCount, $result);
    }

    #[DataProviderExternal(RecommendationServiceDataProvider::class, 'getMoviesStartingWithWEven')]
    public function testGetMoviesStartingWithWEvenLength($titles, $shouldMatch, $shouldNotMatch): void
    {
        $service = $this->createService($titles);
        $result = $service->getRecommendations(StartingWithWEvenLengthStrategy::NAME);

        foreach ($shouldMatch as $title) {
            $this->assertContains($title, $result);
        }
        foreach ($shouldNotMatch as $title) {
            $this->assertNotContains($title, $result);
        }
    }

    #[DataProviderExternal(RecommendationServiceDataProvider::class, 'getMultiWordTitles')]
    public function testGetMultiWordTitles($titles, $shouldMatch, $shouldNotMatch): void
    {
        $service = $this->createService($titles);
        $result = $service->getRecommendations(MultiWordTitlesStrategy::NAME);

        foreach ($shouldMatch as $title) {
            $this->assertContains($title, $result);
        }
        foreach ($shouldNotMatch as $title) {
            $this->assertNotContains($title, $result);
        }
    }

    /**
     * Test that all RecommendationService functions are returning string arrays.
     */
    #[DataProviderExternal(RecommendationServiceDataProvider::class, 'resultsAreStringArrays')]
    public function testResultsAreStringArrays($titles): void
    {
        $service = $this->createService($titles);

        foreach ($service->getRecommendations(RandomThreeStrategy::NAME) as $title) {
            $this->assertIsString($title);
        }

        foreach ($service->getRecommendations(StartingWithWEvenLengthStrategy::NAME) as $title) {
            $this->assertIsString($title);
        }

        foreach ($service->getRecommendations(MultiWordTitlesStrategy::NAME) as $title) {
            $this->assertIsString($title);
        }
    }

    /**
     * Create a RecommendationService with mocked repository returning given titles.
     *
     * @param string[] $titles
     */
    private function createService(array $titles): RecommendationService
    {
        $repository = $this->createMock(MovieRepository::class);
        $repository->method('findAll')->willReturn($titles);

        $strategies = [
            new RandomThreeStrategy($repository),
            new StartingWithWEvenLengthStrategy($repository),
            new MultiWordTitlesStrategy($repository),
        ];

        return new RecommendationService($strategies);
    }
}
