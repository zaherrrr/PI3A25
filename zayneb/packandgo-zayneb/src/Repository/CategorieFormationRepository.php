<?php

namespace App\Repository;

use App\Entity\CategorieFormation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategorieFormation|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategorieFormation|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategorieFormation[]    findAll()
 * @method CategorieFormation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieFormationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategorieFormation::class);
    }
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.nom_cat_frt like :val or b.description_cat_frt like :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return CategorieFormation[] Returns an array of CategorieFormation objects
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
    public function findOneBySomeField($value): ?CategorieFormation
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
