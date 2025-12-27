<?php

declare(strict_types=1);

namespace App\Service\Recommendation\Strategy;

use App\Repository\MovieRepository;

class StartingWithWEvenLengthStrategy implements RecommendationStrategyInterface
{
    public const NAME = 'starting_with_w_even_length';

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

        return array_filter(
            $titles,
            static function (string $title): bool {
                // Check if the title starts with 'W'
                if (!str_starts_with($title, 'W')) {
                    return false;
                }
                // Check if title has even number of characters
                $length = mb_strlen($title);
                return $length % 2 === 0;
            }
        );
    }
}
