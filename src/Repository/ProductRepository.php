<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findByCategories(array $categories)
    {
        $qb = $this->createQueryBuilder('p');

        if (!empty($categories)) {
            $qb->where('p.category IN (:categories)')
                ->setParameter('categories', $categories);
        }

        return $qb->getQuery()->getResult();
    }
}
