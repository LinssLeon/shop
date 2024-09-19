<?php

namespace App\Repository;

use App\Entity\Review;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Review>
 *
 * @method Review|null find($id, $lockMode = null, $lockVersion = null)
 * @method Review|null findOneBy(array $criteria, array $orderBy = null)
 * @method Review[]    findAll()
 * @method Review[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Review::class);
    }

    public function save(Review $review): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($review);
        $entityManager->flush();
    }

    public function remove(Review $review): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($review);
        $entityManager->flush();
    }

    // Beispiel für eine benutzerdefinierte Abfrage
    public function findByRating(int $rating): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.rating = :rating')
            ->setParameter('rating', $rating)
            ->orderBy('r.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
