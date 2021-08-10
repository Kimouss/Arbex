<?php

namespace App\Entity\Tag;

use App\Entity\User\User;
use App\Repository\Tag\AvailabilityTagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AvailabilityTagRepository::class)
 */
class AvailabilityTag extends Tag
{
    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="availabilityTags")
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
            $user->addAvailabilityTag($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeAvailabilityTag($this);
        }

        return $this;
    }
}
