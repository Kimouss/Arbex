<?php

namespace App\Repository\Tag;

use App\Entity\Tag\UserTag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserTag|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserTag|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserTag[]    findAll()
 * @method UserTag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserTagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserTag::class);
    }

    public function getAllQuery(): Query
    {
        return $this->createQueryBuilder('tag')
            ->getQuery();
    }

    public function getAllByUser($userId): Query
    {
        return $this->createQueryBuilder('tag')
            ->join('tag.user', 'user')
            ->where('user.id = :user_id')
            ->setParameter('user_id', $userId)
            ->getQuery();
    }

    public function getSearchQuery($userId, $params): Query
    {
        $qb = $this->createQueryBuilder('tag')
            ->join('tag.user', 'user')
            ->where('user.id = :user_id')
            ->setParameter('user_id', $userId);

        if (array_key_exists('title', $params) && !empty($params['title'])) {
            $qb->andWhere('tag.title LIKE :title')->setParameter('title', '%'.$params['title'].'%');
        }

        return $qb->getQuery();
    }
}
