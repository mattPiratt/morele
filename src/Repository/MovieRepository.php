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
     * Returns 3 random unique movies.
     *
     * @return Movie[]
     */
    public function findRandomUnique(int $limit = 3): array
    {
        $allUnique = $this->findAllUnique();
        $count = count($allUnique);

        if ($count <= $limit) {
            return $allUnique;
        }

        $randomKeys = array_rand($allUnique, $limit);
        if (!is_array($randomKeys)) {
            $randomKeys = [$randomKeys];
        }

        return array_map(
            static fn(int|string $key): Movie => $allUnique[$key],
            $randomKeys
        );
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

    /**
     * Returns movies starting with 'W' and having an even number of characters.
     *
     * @return Movie[]
     */
    public function findStartingWithWEvenLength(): array
    {
        $movies = $this->createQueryBuilder('m')
            ->where('m.title LIKE :starts_with')
            ->groupBy('m.title')
            ->setParameter('starts_with', 'W%')
            ->getQuery()
            ->getResult();

        return array_filter(
            $movies,
            static fn(Movie $movie): bool => mb_strlen($movie->getTitle()) % 2 === 0
        );
    }

    /**
     * Returns movies with multi-word titles.
     *
     * @return Movie[]
     */
    public function findMultiWord(): array
    {
        return $this->createQueryBuilder('m')
            ->where('m.title LIKE :multi_word')
            ->groupBy('m.title')
            ->setParameter('multi_word', '% %')
            ->getQuery()
            ->getResult();
    }
}
