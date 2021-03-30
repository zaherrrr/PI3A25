<?php

namespace App\Repository;

use App\Entity\OffreFreelance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OffreFreelance|null find($id, $lockMode = null, $lockVersion = null)
 * @method OffreFreelance|null findOneBy(array $criteria, array $orderBy = null)
 * @method OffreFreelance[]    findAll()
 * @method OffreFreelance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OffreFreelanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OffreFreelance::class);
    }

    // /**
    //  * @return OffreFreelance[] Returns an array of OffreFreelance objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OffreFreelance
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getWithSearchQueryBuilder(?string $term): QueryBuilder
    {



    }
}
