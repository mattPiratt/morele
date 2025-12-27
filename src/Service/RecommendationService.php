<?php

declare(strict_types=1);

namespace App\Service;

use App\Service\Recommendation\Strategy\RecommendationStrategyInterface;
use InvalidArgumentException;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

/**
 * Service providing movie recommendation algorithms.
 */
class RecommendationService
{
    /**
     * @param iterable<RecommendationStrategyInterface> $strategies
     */
    public function __construct(
        #[TaggedIterator(RecommendationStrategyInterface::class)]
        private readonly iterable $strategies
    ) {
    }

    /**
     * @return string[]
     */
    public function getRecommendations(string $strategyName): array
    {
        foreach ($this->strategies as $strategy) {
            if ($strategy->getName() === $strategyName) {
                return $strategy->getRecommendations();
            }
        }

        throw new InvalidArgumentException(sprintf('Strategy with name "%s" not found.', $strategyName));
    }
}
