<?php

declare(strict_types=1);

namespace App\Service;

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
     * @return string[]
     */
    public function getRandomThree(): array
    {
        $titles = $this->movieRepository->findAll();

        if (count($titles) <= 3) {
            return $titles;
        }

        $randomKeys = array_rand($titles, 3);

        return array_map(
            static fn(int|string $key): string => $titles[$key],
            $randomKeys
        );
    }

    /**
     * Get all movies starting with 'W' that have an even number of characters in the title.
     *
     * @return string[]
     */
    public function getMoviesStartingWithWEvenLength(): array
    {
        $titles = $this->movieRepository->findAll();

        return array_values(
            array_filter(
                $titles,
                static function (string $title): bool {
                    // Check if title starts with 'W'
                    if (!str_starts_with($title, 'W')) {
                        return false;
                    }
                    // Check if title has even number of characters
                    $length = mb_strlen($title);
                    return $length % 2 === 0;
                }
            )
        );
    }

    /**
     * Get all movie titles that consist of more than one word.
     *
     * @return string[]
     */
    public function getMultiWordTitles(): array
    {
        $titles = $this->movieRepository->findAll();

        return array_values(
            array_filter(
                $titles,
                static function (string $title): bool {
                    // Count words by splitting on whitespace
                    $words = preg_split('/\s+/', trim($title));
                    return is_array($words) && count($words) > 1;
                }
            )
        );
    }
}
