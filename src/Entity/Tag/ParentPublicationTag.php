<?php

namespace App\Entity\Tag;

use App\Repository\Tag\ParentPublicationTagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParentPublicationTagRepository::class)
 */
class ParentPublicationTag extends Tag
{
    /**
     * @ORM\OneToMany(targetEntity=PublicationTag::class, mappedBy="user")
     */
    protected Collection $children;

    public function __construct()
    {
        parent::__construct();
        $this->children = new ArrayCollection();
    }

    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addPublicationTag(PublicationTag $publication): self
    {
        if (!$this->children->contains($publication)) {
            $this->children[] = $publication;
            $publication->setParent($this);
        }

        return $this;
    }

    public function removePublicationTag(PublicationTag $publication): self
    {
        if ($this->children->removeElement($publication)) {
            // set the owning side to null (unless already changed)
            if ($publication->getParent() === $this) {
                $publication->setParent(null);
            }
        }

        return $this;
    }
}
