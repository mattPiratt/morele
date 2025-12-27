<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Movie;
use App\Repository\MovieRepository;

/**
 * Service providing movie recommendation algorithms.
 */
class RecommendationService
{
    public function __construct(
        private readonly MovieRepository $movieRepository
    ) {
    }

    /**
     * Get 3 random movie titles.
     *
     * @return Movie[]
     */
    public function getRandomThree(): array
    {
        return $this->movieRepository->findRandomUnique(3);
    }

    /**
     * Get all movies starting with 'W' that have an even number of characters in the title.
     *
     * @return Movie[]
     */
    public function getMoviesStartingWithWEvenLength(): array
    {
        return $this->movieRepository->findStartingWithWEvenLength();
    }

    /**
     * Get all movie titles that consist of more than one word.
     *
     * @return Movie[]
     */
    public function getMultiWordTitles(): array
    {
        return $this->movieRepository->findMultiWord();
    }
}
