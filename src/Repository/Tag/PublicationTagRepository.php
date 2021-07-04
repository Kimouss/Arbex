<?php

namespace App\Repository\Tag;

use App\Entity\Tag\PublicationTag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PublicationTag|null find($id, $lockMode = null, $lockVersion = null)
 * @method PublicationTag|null findOneBy(array $criteria, array $orderBy = null)
 * @method PublicationTag[]    findAll()
 * @method PublicationTag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PublicationTagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PublicationTag::class);
    }
}
