<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Repository\MovieRepository;
use App\Service\RecommendationService;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for RecommendationService.
 */
class RecommendationServiceTest extends TestCase
{
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

    /**
     * Test that getRandomThree returns exactly 3 movies when more are available.
     */
    public function testGetRandomThreeReturnsThreeMovies(): void
    {
        $titles = [
            'Movie One',
            'Movie Two',
            'Movie Three',
            'Movie Four',
            'Movie Five',
        ];

        $service = $this->createService($titles);
        $result = $service->getRandomThree();

        $this->assertCount(3, $result);
    }

    /**
     * Test that getRandomThree returns all movies when less than 3 are available.
     */
    public function testGetRandomThreeReturnsAllWhenLessThanThree(): void
    {
        $titles = [
            'Movie One',
            'Movie Two',
        ];

        $service = $this->createService($titles);
        $result = $service->getRandomThree();

        $this->assertCount(2, $result);
    }

    /**
     * Test that getRandomThree returns empty array when no movies available.
     */
    public function testGetRandomThreeReturnsEmptyWhenNoMovies(): void
    {
        $service = $this->createService([]);
        $result = $service->getRandomThree();

        $this->assertCount(0, $result);
    }

    /**
     * Test that getMoviesStartingWithWEvenLength filters correctly.
     */
    public function testGetMoviesStartingWithWEvenLength(): void
    {
        $titles = [
            'Whiplash',       // W + 8 chars (even) - should match
            'Władca',         // W + 6 chars (even) - should match
            'Matrix',         // M - should not match (wrong letter)
            'Władca Pierścieni', // W + odd chars - should not match
            'Wyspa tajemnic', // W + 14 chars (even) - should match
        ];

        $service = $this->createService($titles);
        $result = $service->getMoviesStartingWithWEvenLength();

        $this->assertContains('Whiplash', $result);
        $this->assertContains('Władca', $result);
        $this->assertContains('Wyspa tajemnic', $result);
        $this->assertNotContains('Matrix', $result);
    }

    /**
     * Test that getMoviesStartingWithWEvenLength returns empty for no matches.
     */
    public function testGetMoviesStartingWithWEvenLengthNoMatches(): void
    {
        $titles = [
            'Matrix',
            'Django',
        ];

        $service = $this->createService($titles);
        $result = $service->getMoviesStartingWithWEvenLength();

        $this->assertCount(0, $result);
    }

    /**
     * Test that getMultiWordTitles returns only multi-word titles.
     */
    public function testGetMultiWordTitles(): void
    {
        $titles = [
            'Pulp Fiction',      // 2 words - should match
            'Matrix',            // 1 word - should not match
            'Leon zawodowiec',   // 2 words - should match
            'Django',            // 1 word - should not match
            'Fight Club',        // 2 words - should match
        ];

        $service = $this->createService($titles);
        $result = $service->getMultiWordTitles();

        $this->assertContains('Pulp Fiction', $result);
        $this->assertContains('Leon zawodowiec', $result);
        $this->assertContains('Fight Club', $result);
        $this->assertNotContains('Matrix', $result);
        $this->assertNotContains('Django', $result);
    }

    /**
     * Test that getMultiWordTitles returns empty for single-word movies only.
     */
    public function testGetMultiWordTitlesNoMatches(): void
    {
        $titles = [
            'Matrix',
            'Django',
            'Gladiator',
        ];

        $service = $this->createService($titles);
        $result = $service->getMultiWordTitles();

        $this->assertCount(0, $result);
    }

    /**
     * Test that getMultiWordTitles handles titles with multiple spaces correctly.
     */
    public function testGetMultiWordTitlesWithMultipleSpaces(): void
    {
        $titles = [
            'Harry Potter i Kamień Filozoficzny', // 5 words
            'Władca Pierścieni: Drużyna Pierścienia', // 4 words
        ];

        $service = $this->createService($titles);
        $result = $service->getMultiWordTitles();

        $this->assertCount(2, $result);
        $this->assertContains('Harry Potter i Kamień Filozoficzny', $result);
        $this->assertContains('Władca Pierścieni: Drużyna Pierścienia', $result);
    }

    /**
     * Test that results are string arrays.
     */
    public function testResultsAreStringArrays(): void
    {
        $titles = [
            'Pulp Fiction',
            'Matrix',
            'Whiplash',
            'Wielki Gatsby',
        ];

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
}
