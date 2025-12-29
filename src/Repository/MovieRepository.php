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
        $allIds = $this->createQueryBuilder('m')
            ->select('m.id')
            ->groupBy('m.title')
            ->getQuery()
            ->getSingleColumnResult();

        if (empty($allIds)) {
            return [];
        }

        $randomKeys = array_rand($allIds, $limit);
        if (!is_array($randomKeys)) {
            $randomKeys = [$randomKeys];
        }

        $selectedIds = array_map(fn($key) => $allIds[$key], $randomKeys);

        return $this->findBy(['id' => $selectedIds]);
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
