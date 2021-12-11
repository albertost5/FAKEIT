<?php

namespace App\Repository;

use App\Entity\Play;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Play|null find($id, $lockMode = null, $lockVersion = null)
 * @method Play|null findOneBy(array $criteria, array $orderBy = null)
 * @method Play[]    findAll()
 * @method Play[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Play::class);
    }

    // /**
    //  * @return Play[] Returns an array of Play objects
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
    public function findOneBySomeField($value): ?Play
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findWinsByUserId($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.winner_id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
            // getResult() = 1 o más resultados => array
        ;
    }

    public function findLosesByUserId($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.loser_id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
            // getResult() = 1 o más resultados => array
        ;
    }
}
