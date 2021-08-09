<?php

namespace App\Repository\Tag;

use App\Entity\Tag\TrainingStageTag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TrainingStageTag|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrainingStageTag|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrainingStageTag[]    findAll()
 * @method TrainingStageTag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrainingStageTagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrainingStageTag::class);
    }

    public function getAllQuery(): Query
    {
        return $this->createQueryBuilder('training_stage_tag')
            ->getQuery();
    }
}
