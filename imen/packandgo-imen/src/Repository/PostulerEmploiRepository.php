<?php

namespace App\Repository;

use App\Entity\PostulerEmploi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PostulerEmploi|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostulerEmploi|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostulerEmploi[]    findAll()
 * @method PostulerEmploi[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostulerEmploiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostulerEmploi::class);
    }
    public function findOneBySomeField($value,$value2)
    {
        return $this->createQueryBuilder('l')
            ->Where('l.offreEmploi = :val')
            ->andWhere('l.user = :val1')
            ->setParameter('val', $value)
            ->setParameter('val1', $value2)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    // /**
    //  * @return PostulerEmploi[] Returns an array of PostulerEmploi objects
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
    public function findOneBySomeField($value): ?PostulerEmploi
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
