<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use App\Service\RecommendationService;
use App\Tests\DataProvider\Service\RecommendationServiceDataProvider;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\TestCase;

class RecommendationServiceTest extends TestCase
{

    #[DataProviderExternal(RecommendationServiceDataProvider::class, 'getRandomThree')]
    public function testGetRandomThree($movies, $expectedCount): void
    {
        $service = $this->createService($movies);
        $result = $service->getRandomThree();

        $this->assertCount($expectedCount, $result);
        foreach ($result as $movie) {
            $this->assertInstanceOf(Movie::class, $movie);
        }
    }

    #[DataProviderExternal(RecommendationServiceDataProvider::class, 'getMoviesStartingWithWEven')]
    public function testGetMoviesStartingWithWEvenLength($movies, $shouldMatch, $shouldNotMatch): void
    {
        $service = $this->createService($movies);
        $result = $service->getMoviesStartingWithWEvenLength();
        $resultTitles = array_map(fn(Movie $movie) => $movie->getTitle(), $result);

        foreach ($shouldMatch as $title) {
            $this->assertContains($title, $resultTitles);
        }
        foreach ($shouldNotMatch as $title) {
            $this->assertNotContains($title, $resultTitles);
        }
    }

    #[DataProviderExternal(RecommendationServiceDataProvider::class, 'getMultiWordTitles')]
    public function testGetMultiWordTitles($movies, $shouldMatch, $shouldNotMatch): void
    {
        $service = $this->createService($movies);
        $result = $service->getMultiWordTitles();
        $resultTitles = array_map(fn(Movie $movie) => $movie->getTitle(), $result);

        foreach ($shouldMatch as $title) {
            $this->assertContains($title, $resultTitles);
        }
        foreach ($shouldNotMatch as $title) {
            $this->assertNotContains($title, $resultTitles);
        }
    }

    /**
     * Test that all RecommendationService functions are returning Movie arrays.
     */
    #[DataProviderExternal(RecommendationServiceDataProvider::class, 'resultsAreMovieArrays')]
    public function testResultsAreMovieArrays($movies): void
    {
        $service = $this->createService($movies);

        foreach ($service->getRandomThree() as $movie) {
            $this->assertInstanceOf(Movie::class, $movie);
        }

        foreach ($service->getMoviesStartingWithWEvenLength() as $movie) {
            $this->assertInstanceOf(Movie::class, $movie);
        }

        foreach ($service->getMultiWordTitles() as $movie) {
            $this->assertInstanceOf(Movie::class, $movie);
        }
    }

    /**
     * Create a RecommendationService with mocked repository returning given movies.
     *
     * @param Movie[] $movies
     */
    private function createService(array $movies): RecommendationService
    {
        $repository = $this->createMock(MovieRepository::class);
        $repository->method('findAllUnique')->willReturn($movies);

        return new RecommendationService($repository);
    }
}
