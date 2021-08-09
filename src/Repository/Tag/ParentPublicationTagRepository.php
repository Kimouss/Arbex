<?php

namespace App\Repository\Tag;

use App\Entity\Tag\ParentPublicationTag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ParentPublicationTag|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParentPublicationTag|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParentPublicationTag[]    findAll()
 * @method ParentPublicationTag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParentPublicationTagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ParentPublicationTag::class);
    }

    public function getAllQuery(): Query
    {
        return $this->createQueryBuilder('parent_publication_tag')
            ->getQuery();
    }
}
