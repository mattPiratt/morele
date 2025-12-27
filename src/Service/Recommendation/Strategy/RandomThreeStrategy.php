<?php

declare(strict_types=1);

namespace App\Service\Recommendation\Strategy;

use App\Repository\MovieRepository;

class RandomThreeStrategy implements RecommendationStrategyInterface
{
    public const NAME = 'random_three';

    public function __construct(
        private readonly MovieRepository $movieRepository
    ) {
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getRecommendations(): array
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
}
