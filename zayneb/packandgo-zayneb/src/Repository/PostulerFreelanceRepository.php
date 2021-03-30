<?php

namespace App\Repository;

use App\Entity\PostulerFreelance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PostulerFreelance|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostulerFreelance|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostulerFreelance[]    findAll()
 * @method PostulerFreelance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostulerFreelanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostulerFreelance::class);
    }
    public function findOneBySomeField($value,$value2)
    {
        return $this->createQueryBuilder('l')
            ->Where('l.offreFreelance = :val' )
            ->andWhere('l.user = :val1')
            ->setParameter('val', $value)
            ->setParameter('val1', $value2)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    // /**
    //  * @return PostulerFreelance[] Returns an array of PostulerFreelance objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PostulerFreelance
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
