<?php

namespace App\Entity\Tag;

use App\Entity\User\User;
use App\Repository\Tag\AffiliationGroupTagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AffiliationGroupTagRepository::class)
 */
class AffiliationGroupTag extends Tag
{
    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="affiliationGroupTags")
     */
    private $users;

    public function __construct()
    {
        parent::__construct();
        $this->users = new ArrayCollection();
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addAffiliationGroupTag($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeAffiliationGroupTag($this);
        }

        return $this;
    }
}
