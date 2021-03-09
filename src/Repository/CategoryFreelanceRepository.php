<?php

namespace App\Repository;

use App\Entity\CategoryFreelance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategoryFreelance|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryFreelance|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryFreelance[]    findAll()
 * @method CategoryFreelance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryFreelanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryFreelance::class);
    }

    // /**
    //  * @return CategoryFreelance[] Returns an array of CategoryFreelance objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CategoryFreelance
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
