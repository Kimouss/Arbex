<?php

namespace App\Entity\Tag;

use App\Repository\Tag\AffiliationGroupTagRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AffiliationGroupTagRepository::class)
 */
class AffiliationGroupTag extends Tag
{
}
