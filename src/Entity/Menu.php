<?php

namespace App\Entity;

use App\Repository\MenuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MenuRepository::class)
 */
class Menu
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?string $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $route;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $label;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $icon;

    /**
     * @ORM\ManyToOne(targetEntity=Menu::class, inversedBy="parent")
     */
    private ?Menu $menu;

    /**
     * @ORM\OneToMany(targetEntity=Menu::class, mappedBy="menu")
     */
    private Collection $parent;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $isActive = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $isUri = false;

    private ?int $position;

    public function __construct()
    {
        $this->parent = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoute(): ?string
    {
        return $this->route;
    }

    public function setRoute(string $route): self
    {
        $this->route = $route;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function getMenu(): ?self
    {
        return $this->menu;
    }

    public function setMenu(?self $menu): self
    {
        $this->menu = $menu;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getParent(): Collection
    {
        return $this->parent;
    }

    public function addParent(self $parent): self
    {
        if (!$this->parent->contains($parent)) {
            $this->parent[] = $parent;
            $parent->setMenu($this);
        }

        return $this;
    }

    public function removeParent(self $parent): self
    {
        if ($this->parent->removeElement($parent)) {
            // set the owning side to null (unless already changed)
            if ($parent->getMenu() === $this) {
                $parent->setMenu(null);
            }
        }

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getIsUri(): ?bool
    {
        return $this->isUri;
    }

    public function setIsUri(bool $isUri): self
    {
        $this->isUri = $isUri;

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
}
