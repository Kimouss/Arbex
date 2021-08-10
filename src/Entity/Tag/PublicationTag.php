<?php

namespace App\Entity\Tag;

use App\Entity\Publication;
use App\Repository\Tag\PublicationTagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @ORM\ManyToMany(targetEntity=Publication::class, mappedBy="publicationTags")
     */
    public Collection $publications;

    public function __construct()
    {
        parent::__construct();
        $this->publications = new ArrayCollection();
    }

    /**
     * @return Collection|Publication[]
     */
    public function getPublications(): ?Collection
    {
        return $this->publications;
    }

    public function addPublication(Publication $user): self
    {
        if (!$this->publications->contains($user)) {
            $this->publications[] = $user;
            $user->addTag($this);
        }

        return $this;
    }

    public function removePublication(Publication $user): self
    {
        if ($this->publications->contains($user)) {
            $this->publications->removeElement($user);
            $user->removeTag($this);
        }

        return $this;
    }

    public function getPublicationsListToHtml()
    {
        $html = '';
        /** @var Publication $publication */
        foreach ($this->publications->toArray() as $publication) {
            $html .= '<li>'.$publication->getTitle().'</li>';
        }

        return '<ul>'.$html.'</ul>';
    }

    public function getParent(): ParentPublicationTag
    {
        return $this->parent;
    }

    public function setParent(ParentPublicationTag $parent): PublicationTag
    {
        $this->parent = $parent;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getTitle();
    }
}
