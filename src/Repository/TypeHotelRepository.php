<?php

namespace App\Repository;

use App\Entity\TypeHotel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TypeHotel|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeHotel|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeHotel[]    findAll()
 * @method TypeHotel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeHotelRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TypeHotel::class);
    }

//    /**
//     * @return TypeHotel[] Returns an array of TypeHotel objects
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
    public function findOneBySomeField($value): ?TypeHotel
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
