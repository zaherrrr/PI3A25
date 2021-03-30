<?php

namespace App\Repository;

use App\Entity\CategorieEmploi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategorieEmploi|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategorieEmploi|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategorieEmploi[]    findAll()
 * @method CategorieEmploi[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieEmploiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategorieEmploi::class);
    }
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.nomEmploi like :val or b.descriptionEmploi like :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return CategorieEmploi[] Returns an array of CategorieEmploi objects
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
    public function findOneBySomeField($value): ?CategorieEmploi
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
