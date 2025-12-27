<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Movie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Movie>
 */
class MovieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movie::class);
    }

    /**
     * Returns only unique movies
     *
     * @return Movie[]
     */
    public function findAllUnique(): array
    {
        return $this->createQueryBuilder('m')
            ->groupBy('m.title')
            ->getQuery()
            ->getResult();
    }
}
