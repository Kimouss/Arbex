<?php

namespace App\Entity\Tag;

use App\Repository\Tag\AvailabilityTagRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AvailabilityTagRepository::class)
 */
class AvailabilityTag extends Tag
{
}
