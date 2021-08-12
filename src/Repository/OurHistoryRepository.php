<?php

namespace App\Repository;

use App\Entity\OurHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OurHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method OurHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method OurHistory[]    findAll()
 * @method OurHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OurHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OurHistory::class);
    }

    public function getAllQuery(): Query
    {
        return $this->createQueryBuilder('our_history')->getQuery();
    }

    // /**
    //  * @return OurHistory[] Returns an array of OurHistory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OurHistory
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
