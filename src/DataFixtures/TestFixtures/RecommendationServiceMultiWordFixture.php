<?php

declare(strict_types=1);

namespace App\DataFixtures\TestFixtures;

use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RecommendationServiceMultiWordFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $movies = [
            'Pulp Fiction',      // 2 words - should match
            'Leon zawodowiec',   // 2 words - should match
            'Fight Club',        // 2 words - should match
            'Matrix',            // 1 word - should NOT match
            'Django',            // 1 word - should NOT match
        ];

        foreach ($movies as $title) {
            $manager->persist(new Movie($title));
        }

        $manager->flush();
    }
}
