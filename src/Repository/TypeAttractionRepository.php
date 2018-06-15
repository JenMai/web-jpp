<?php

namespace App\Repository;

use App\Entity\TypeAttraction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TypeAttraction|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeAttraction|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeAttraction[]    findAll()
 * @method TypeAttraction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeAttractionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TypeAttraction::class);
    }

//    /**
//     * @return TypeAttraction[] Returns an array of TypeAttraction objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TypeAttraction
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
