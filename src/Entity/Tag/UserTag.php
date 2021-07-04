<?php

namespace App\Entity\Tag;

use App\Entity\User\User;
use App\Repository\Tag\UserTagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserTagRepository::class)
 */
class UserTag extends Tag
{
    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="tags")
     */
    public Collection $users;

    public function __construct()
    {
        parent::__construct();
        $this->users = new ArrayCollection();
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): ?Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addTag($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeTag($this);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getTitle();
    }

    public function getUsersListToHtml()
    {
        $html = '';
        /** @var User $user */
        foreach ($this->users->toArray() as $user) {
            $html .= '<li>'.$user->getEmail().'</li>';
        }

        return '<ul>'.$html.'</ul>';
    }
}
