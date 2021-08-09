<?php

namespace App\Entity\Tag;

use App\Repository\Tag\TrainingStageTagRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TrainingStageTagRepository::class)
 */
class TrainingStageTag extends Tag
{
}
