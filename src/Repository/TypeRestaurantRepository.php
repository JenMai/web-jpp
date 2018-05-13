<?php

namespace App\Repository;

use App\Entity\TypeRestaurant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TypeRestaurant|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeRestaurant|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeRestaurant[]    findAll()
 * @method TypeRestaurant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeRestaurantRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TypeRestaurant::class);
    }

//    /**
//     * @return TypeRestaurant[] Returns an array of TypeRestaurant objects
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
    public function findOneBySomeField($value): ?TypeRestaurant
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
