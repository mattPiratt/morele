<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\DataFixtures\TestFixtures\RecommendationServiceMultiWordFixture;
use App\DataFixtures\TestFixtures\RecommendationServiceRandomFixture;
use App\DataFixtures\TestFixtures\RecommendationServiceWLetterFixture;
use App\Entity\Movie;
use App\Service\RecommendationService;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RecommendationServiceTest extends KernelTestCase
{
    protected AbstractDatabaseTool $databaseTool;
    private RecommendationService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $container = self::getContainer();
        /** @var DatabaseToolCollection $databaseToolCollection */
        $databaseToolCollection = $container->get(DatabaseToolCollection::class);
        $this->databaseTool = $databaseToolCollection->get();

        /** @var RecommendationService $service */
        $service = $container->get(RecommendationService::class);
        $this->service = $service;
    }

    public function testGetRandomThree(): void
    {
        $this->databaseTool->loadFixtures([RecommendationServiceRandomFixture::class]);

        $result = $this->service->getRandomThree();

        $this->assertCount(3, $result);
        foreach ($result as $movie) {
            $this->assertInstanceOf(Movie::class, $movie);
        }
    }

    public function testGetMoviesStartingWithWEvenLength(): void
    {
        $this->databaseTool->loadFixtures([RecommendationServiceWLetterFixture::class]);

        $result = $this->service->getMoviesStartingWithWEvenLength();
        $resultTitles = array_map(fn(Movie $movie) => $movie->getTitle(), $result);

        $this->assertCount(3, $result);
        $this->assertContains('Whiplash', $resultTitles);
        $this->assertContains('Władca', $resultTitles);
        $this->assertContains('Wyspa tajemnic', $resultTitles);
        $this->assertNotContains('Władca Pierścieni', $resultTitles);
        $this->assertNotContains('Matrix', $resultTitles);
    }

    public function testGetMultiWordTitles(): void
    {
        $this->databaseTool->loadFixtures([RecommendationServiceMultiWordFixture::class]);

        $result = $this->service->getMultiWordTitles();
        $resultTitles = array_map(fn(Movie $movie) => $movie->getTitle(), $result);

        $this->assertCount(3, $result);
        $this->assertContains('Pulp Fiction', $resultTitles);
        $this->assertContains('Leon zawodowiec', $resultTitles);
        $this->assertContains('Fight Club', $resultTitles);
        $this->assertNotContains('Matrix', $resultTitles);
        $this->assertNotContains('Django', $resultTitles);
    }

    /**
     * Test that all RecommendationService functions are returning Movie arrays.
     */
    public function testResultsAreMovieArrays(): void
    {
        $this->databaseTool->loadFixtures([RecommendationServiceRandomFixture::class]);

        foreach ($this->service->getRandomThree() as $movie) {
            $this->assertInstanceOf(Movie::class, $movie);
        }

        foreach ($this->service->getMoviesStartingWithWEvenLength() as $movie) {
            $this->assertInstanceOf(Movie::class, $movie);
        }

        foreach ($this->service->getMultiWordTitles() as $movie) {
            $this->assertInstanceOf(Movie::class, $movie);
        }
    }
}
