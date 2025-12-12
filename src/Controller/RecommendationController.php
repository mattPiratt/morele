<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\RecommendationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RecommendationController extends AbstractController
{
    public function __construct(
        private readonly RecommendationService $recommendationService
    ) {
    }

    /**
     * Display 3 random movie recommendations.
     */
    #[Route('/', name: 'recommendation_random', methods: ['GET'])]
    public function randomAction(): Response
    {
        $movies = $this->recommendationService->getRandomThree();

        return $this->render('recommendation/random.html.twig', [
            'movies' => $movies,
            'title' => 'Random Recommendations',
        ]);
    }

    /**
     * Display movies starting with 'W' that have an even number of characters.
     */
    #[Route('/w-even', name: 'recommendation_w_even', methods: ['GET'])]
    public function wEvenAction(): Response
    {
        $movies = $this->recommendationService->getMoviesStartingWithWEvenLength();

        return $this->render('recommendation/w_even.html.twig', [
            'movies' => $movies,
            'title' => 'Movies Starting with W (Even Length)',
        ]);
    }

    /**
     * Display movies with multi-word titles.
     */
    #[Route('/multi-word', name: 'recommendation_multi_word', methods: ['GET'])]
    public function multiWordAction(): Response
    {
        $movies = $this->recommendationService->getMultiWordTitles();

        return $this->render('recommendation/multi_word.html.twig', [
            'movies' => $movies,
            'title' => 'Multi-Word Titles',
        ]);
    }
}
