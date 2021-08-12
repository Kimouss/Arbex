<?php

namespace App\Entity\User;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Publication;
use App\Entity\Tag\AffiliationGroupTag;
use App\Entity\Tag\AvailabilityTag;
use App\Entity\Tag\TrainingStageTag;
use App\Repository\User\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\Lazy\LazyUuidFromString;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ApiResource(
 *     attributes={
 *          "normalization_context"={"groups"={
 *              "User:output",
 *              "User:io",
 *          }},
 *          "denormalization_context"={"groups"={
 *              "User:input",
 *              "User:io",
 *          }}
 *      },
 *     collectionOperations={
 *          "get",
 *     }
 * )
 * @UniqueEntity("email")
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @Vich\Uploadable
 */
class User implements UserInterface
{
    public const ROLE_PUBLIC = 'ROLE_PUBLIC';
    public const ROLE_USER = 'ROLE_USER';
    public const ROLE_ADMIN = 'ROLE_ADMIN';
    public const ROLE_ADMIN_CLIENT = 'ROLE_ADMIN_CLIENT';
    public const ROLE_ADMIN_ARBEX = 'ROLE_ADMIN_ARBEX';

    public const ARRAY_ROLES = [
        self::ROLE_PUBLIC => self::ROLE_PUBLIC,
        self::ROLE_USER => self::ROLE_USER,
        self::ROLE_ADMIN => self::ROLE_ADMIN,
        self::ROLE_ADMIN_CLIENT => self::ROLE_ADMIN_CLIENT,
        self::ROLE_ADMIN_ARBEX => self::ROLE_ADMIN_ARBEX,
    ];

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
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private string $email;

    /**
     * @ORM\Column(type="json")
     */
    private array $roles = ['ROLE_USER'];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private string $password;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $profile;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $isActive = false;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $userProfilImage;

    /**
     * @Vich\UploadableField(mapping="user_profil", fileNameProperty="userProfilImage")
     * @var File
     */
    private $userProfilImageFile;

    /**
     * @ORM\OneToOne(targetEntity=Identity::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     * @Assert\Valid()
     */
    private Identity $identity;

    /**
     * @ORM\OneToMany(targetEntity=Publication::class, mappedBy="user")
     */
    private Collection $publications;

    /**
     * @ORM\ManyToMany(targetEntity=AffiliationGroupTag::class, inversedBy="users")
     */
    private Collection $affiliationGroupTags;

    /**
     * @ORM\ManyToMany(targetEntity=AvailabilityTag::class, inversedBy="users")
     */
    private Collection $availabilityTags;

    /**
     * @ORM\ManyToMany(targetEntity=TrainingStageTag::class, inversedBy="users")
     */
    private Collection $trainingStageTags;

    public function __construct()
    {
        $this->publications = new ArrayCollection();
        $this->affiliationGroupTags = new ArrayCollection();
        $this->availabilityTags = new ArrayCollection();
        $this->trainingStageTags = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getIdentity(): ?Identity
    {
        return $this->identity;
    }

    public function setIdentity(Identity $identity): self
    {
        $this->identity = $identity;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getProfile(): ?string
    {
        return $this->profile;
    }

    /**
     * @param string|null $profile
     * @return User
     */
    public function setProfile(?string $profile): self
    {
        $this->profile = $profile;

        return $this;
    }

    public function __toString(): string
    {
        return $this->email;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return Collection|Publication[]
     */
    public function getPublications(): Collection
    {
        return $this->publications;
    }

    public function addPublication(Publication $publication): self
    {
        if (!$this->publications->contains($publication)) {
            $this->publications[] = $publication;
            $publication->setUser($this);
        }

        return $this;
    }

    public function removePublication(Publication $publication): self
    {
        if ($this->publications->removeElement($publication)) {
            // set the owning side to null (unless already changed)
            if ($publication->getUser() === $this) {
                $publication->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|AffiliationGroupTag[]
     */
    public function getAffiliationGroupTags(): Collection
    {
        return $this->affiliationGroupTags;
    }

    public function getAffiliationGroupTagsToHtml()
    {
        $html = '';
        /** @var AffiliationGroupTag $item */
        foreach ($this->affiliationGroupTags->toArray() as $item) {
            $html .= '<li>'.$item->getTitle().'</li>';
        }

        return '<ul>'.$html.'</ul>';
    }

    public function addAffiliationGroupTag(AffiliationGroupTag $affiliationGroupTag): self
    {
        if (!$this->affiliationGroupTags->contains($affiliationGroupTag)) {
            $this->affiliationGroupTags[] = $affiliationGroupTag;
        }

        return $this;
    }

    public function removeAffiliationGroupTag(AffiliationGroupTag $affiliationGroupTag): self
    {
        $this->affiliationGroupTags->removeElement($affiliationGroupTag);

        return $this;
    }

    /**
     * @return Collection|AvailabilityTag[]
     */
    public function getAvailabilityTags(): Collection
    {
        return $this->availabilityTags;
    }

    public function getAvailabilityTagsToHtml()
    {
        $html = '';
        /** @var AvailabilityTag $item */
        foreach ($this->availabilityTags->toArray() as $item) {
            $html .= '<li>'.$item->getTitle().'</li>';
        }

        return '<ul>'.$html.'</ul>';
    }

    public function addAvailabilityTag(AvailabilityTag $availabilityTag): self
    {
        if (!$this->availabilityTags->contains($availabilityTag)) {
            $this->availabilityTags[] = $availabilityTag;
        }

        return $this;
    }

    public function removeAvailabilityTag(AvailabilityTag $availabilityTag): self
    {
        $this->availabilityTags->removeElement($availabilityTag);

        return $this;
    }

    /**
     * @return Collection|TrainingStageTag[]
     */
    public function getTrainingStageTags(): Collection
    {
        return $this->trainingStageTags;
    }

    public function getTrainingStageTagsToHtml()
    {
        $html = '';
        /** @var TrainingStageTag $item */
        foreach ($this->trainingStageTags->toArray() as $item) {
            $html .= '<li>'.$item->getTitle().'</li>';
        }

        return '<ul>'.$html.'</ul>';
    }

    public function addTrainingStageTag(TrainingStageTag $trainingStageTag): self
    {
        if (!$this->trainingStageTags->contains($trainingStageTag)) {
            $this->trainingStageTags[] = $trainingStageTag;
        }

        return $this;
    }

    public function removeTrainingStageTag(TrainingStageTag $trainingStageTag): self
    {
        $this->trainingStageTags->removeElement($trainingStageTag);

        return $this;
    }

    public function getUserProfilImage(): ?string
    {
        return $this->userProfilImage;
    }

    public function setUserProfilImage(string $userProfilImage): User
    {
        $this->userProfilImage = $userProfilImage;

        return $this;
    }

    public function getUserProfilImageFile(): ?File
    {
        return $this->userProfilImageFile;
    }

    public function setUserProfilImageFile(?File $userProfilImageFile): User
    {
        $this->userProfilImageFile = $userProfilImageFile;
        if (null !== $userProfilImageFile) {
            $this->updatedAt = new \DateTime();
        }

        return $this;
    }
}
