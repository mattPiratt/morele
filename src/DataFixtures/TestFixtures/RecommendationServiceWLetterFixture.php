<?php

declare(strict_types=1);

namespace App\DataFixtures\TestFixtures;

use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RecommendationServiceWLetterFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $movies = [
            'Whiplash',       // W + 8 chars (even) - should match
            'Władca',         // W + 6 chars (even) - should match
            'Wyspa tajemnic', // W + 14 chars (even) - should match
            'Władca Pierścieni', // W + 17 chars (odd) - should NOT match
            'Matrix',         // M - should NOT match
        ];

        foreach ($movies as $title) {
            $manager->persist(new Movie($title));
        }

        $manager->flush();
    }
}
