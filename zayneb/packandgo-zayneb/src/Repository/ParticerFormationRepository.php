<?php

namespace App\Repository;

use App\Entity\ParticerFormation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ParticerFormation|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParticerFormation|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParticerFormation[]    findAll()
 * @method ParticerFormation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParticerFormationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ParticerFormation::class);
    }
    public function findOneBySomeField($value,$value2)
    {
        return $this->createQueryBuilder('l')
            ->Where('l.formation = :val')
            ->andWhere('l.user = :val1')
            ->setParameter('val', $value)
            ->setParameter('val1', $value2)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    // /**
    //  * @return ParticerFormation[] Returns an array of ParticerFormation objects
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
    public function findOneBySomeField($value): ?ParticerFormation
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
