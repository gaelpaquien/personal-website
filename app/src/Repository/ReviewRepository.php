<?php

namespace App\Repository;

use App\Entity\Review;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Review>
 */
class ReviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Review::class);
    }

    public function findAllOrderedActive(): array
    {
        return $this->createQueryBuilder('r')
            ->where('r.status = 1')
            ->orderBy('r.sortOrder', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
