<?php

namespace App\Entity;

use App\Entity\Tag\PublicationTag;
use App\Entity\User\User;
use App\Repository\PublicationRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\Lazy\LazyUuidFromString;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PublicationRepository::class)
 */
class Publication
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidGenerator::class)
     * @Assert\Uuid()
     */
    private LazyUuidFromString $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $url;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $description;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $position;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="publications")
     * @ORM\JoinColumn(nullable=false)
     */
    private User $user;

    /**
     * @ORM\ManyToMany(targetEntity=PublicationTag::class, inversedBy="publications")
     */
    public $publicationTags;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): self
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return Collection|PublicationTag[]
     */
    public function getPublicationTags(): ?Collection
    {
        return $this->publicationTags;
    }

    public function getPublicationTagsToHtml()
    {
        $html = '';
        /** @var PublicationTag $item */
        foreach ($this->publicationTags->toArray() as $item) {
            $html .= '<li>'.$item->getTitle().'</li>';
        }

        return '<ul>'.$html.'</ul>';
    }

    public function addPublicationTag(PublicationTag $publicationTag): self
    {
        if (!$this->publicationTags->contains($publicationTag)) {
            $this->publicationTags[] = $publicationTag;
            $publicationTag->addPublication($this);
        }

        return $this;
    }

    public function removeTag(PublicationTag $publicationTag): self
    {
        if ($this->publicationTags->contains($publicationTag)) {
            $this->publicationTags->removeElement($publicationTag);
            $publicationTag->removePublication($this);
        }

        return $this;
    }
}
