<?php

declare(strict_types=1);

namespace App\Service\Recommendation\Strategy;

use App\Repository\MovieRepository;

class MultiWordTitlesStrategy implements RecommendationStrategyInterface
{
    public const NAME = 'multi_word_titles';

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
                // Count words by splitting on whitespace
                $words = preg_split('/\s+/', trim($title));
                return is_array($words) && count($words) > 1;
            }
        );
    }
}
