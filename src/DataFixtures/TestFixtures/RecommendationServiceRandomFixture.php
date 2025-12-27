<?php

declare(strict_types=1);

namespace App\DataFixtures\TestFixtures;

use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RecommendationServiceRandomFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $movies = [
            'Movie One',
            'Movie Two',
            'Movie Three',
            'Movie Four',
            'Movie Five',
        ];

        foreach ($movies as $title) {
            $manager->persist(new Movie($title));
        }

        $manager->flush();
    }
}
