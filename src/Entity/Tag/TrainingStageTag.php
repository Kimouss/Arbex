<?php

namespace App\Entity\Tag;

use App\Entity\User\User;
use App\Repository\Tag\TrainingStageTagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TrainingStageTagRepository::class)
 */
class TrainingStageTag extends Tag
{
    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="trainingStageTags")
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
            $user->addTrainingStageTag($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeTrainingStageTag($this);
        }

        return $this;
    }
}
