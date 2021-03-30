<?php

namespace App\Repository;

use App\Entity\CategorieQuestionnaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategorieQuestionnaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategorieQuestionnaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategorieQuestionnaire[]    findAll()
 * @method CategorieQuestionnaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieQuestionnaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategorieQuestionnaire::class);
    }
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.nom_cat_qst like :val or b.description_cat_qst like :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }
    // /**
    //  * @return CategorieQuestionnaire[] Returns an array of CategorieQuestionnaire objects
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
    public function findOneBySomeField($value): ?CategorieQuestionnaire
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
