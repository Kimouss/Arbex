<?php

namespace App\Entity\Tag;

use App\Repository\Tag\PublicationTagRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PublicationTagRepository::class)
 */
class PublicationTag extends Tag
{
    /**
     * @ORM\ManyToOne(targetEntity=ParentPublicationTag::class, inversedBy="children")
     */
    protected ParentPublicationTag $parent;

    public function getParent(): ParentPublicationTag
    {
        return $this->parent;
    }

    public function setParent(ParentPublicationTag $parent): PublicationTag
    {
        $this->parent = $parent;

        return $this;
    }
}
