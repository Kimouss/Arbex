<?php

namespace App\Repository\Tag;

use App\Entity\Tag\AvailabilityTag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AvailabilityTag|null find($id, $lockMode = null, $lockVersion = null)
 * @method AvailabilityTag|null findOneBy(array $criteria, array $orderBy = null)
 * @method AvailabilityTag[]    findAll()
 * @method AvailabilityTag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AvailabilityTagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AvailabilityTag::class);
    }

    public function getAllQuery(): Query
    {
        return $this->createQueryBuilder('availability_tag')
            ->getQuery();
    }
}
