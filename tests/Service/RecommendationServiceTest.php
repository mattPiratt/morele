<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Repository\MovieRepository;
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
        $result = $service->getRandomThree();

        $this->assertCount($expectedCount, $result);
    }

    #[DataProviderExternal(RecommendationServiceDataProvider::class, 'getMoviesStartingWithWEven')]
    public function testGetMoviesStartingWithWEvenLength($titles, $shouldMatch, $shouldNotMatch): void
    {
        $service = $this->createService($titles);
        $result = $service->getMoviesStartingWithWEvenLength();

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
        $result = $service->getMultiWordTitles();

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

        foreach ($service->getRandomThree() as $title) {
            $this->assertIsString($title);
        }

        foreach ($service->getMoviesStartingWithWEvenLength() as $title) {
            $this->assertIsString($title);
        }

        foreach ($service->getMultiWordTitles() as $title) {
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

        return new RecommendationService($repository);
    }
}
