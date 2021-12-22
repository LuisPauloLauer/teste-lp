<?php

namespace App\Repository;

use App\Entity\Hashes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Hashes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hashes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hashes[]    findAll()
 * @method Hashes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HashesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hashes::class);
    }

    // /**
    //  * @return Hashes[] Returns an array of Hashes objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Hashes
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
