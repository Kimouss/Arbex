<?php

namespace App\Repository\Tag;

use App\Entity\Tag\AffiliationGroupTag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AffiliationGroupTag|null find($id, $lockMode = null, $lockVersion = null)
 * @method AffiliationGroupTag|null findOneBy(array $criteria, array $orderBy = null)
 * @method AffiliationGroupTag[]    findAll()
 * @method AffiliationGroupTag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AffiliationGroupTagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AffiliationGroupTag::class);
    }

    public function getAllQuery(): Query
    {
        return $this->createQueryBuilder('availability_tag')
            ->getQuery();
    }
}
