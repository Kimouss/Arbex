<?php

namespace App\Repository;

use App\Entity\Publication;
use App\Entity\User\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Publication|null find($id, $lockMode = null, $lockVersion = null)
 * @method Publication|null findOneBy(array $criteria, array $orderBy = null)
 * @method Publication[]    findAll()
 * @method Publication[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PublicationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Publication::class);
    }

    public function getAllQuery(): Query
    {
        return $this->createQueryBuilder('publication')
            ->join('publication.user', 'user')
            ->getQuery();
    }

    public function getAllByUser($userId): Query
    {
        return $this->createQueryBuilder('publication')
            ->join('publication.user', 'user')
            ->where('user.id = :user_id')
            ->setParameter('user_id', $userId)
            ->getQuery();
    }

    public function getSearchQuery($userId, $params): Query
    {
        $qb = $this->createQueryBuilder('publication')
            ->join('publication.user', 'user')
            ->where('user.id = :user_id')
            ->setParameter('user_id', $userId);

        if (array_key_exists('title', $params) && !empty($params['title'])) {
            $qb->andWhere('publication.title LIKE :title')->setParameter('title', '%'.$params['title'].'%');
        }

        return $qb->getQuery();
    }

    // /**
    //  * @return Publication[] Returns an array of Publication objects
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
    public function findOneBySomeField($value): ?Publication
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
