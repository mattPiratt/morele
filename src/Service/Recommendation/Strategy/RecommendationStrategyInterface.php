<?php

declare(strict_types=1);

namespace App\Service\Recommendation\Strategy;

interface RecommendationStrategyInterface
{
    public function getName(): string;

    /**
     * @return string[]
     */
    public function getRecommendations(): array;
}
