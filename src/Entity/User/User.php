<?php

namespace App\Entity\User;

use App\Repository\User\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\Lazy\LazyUuidFromString;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
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
    private $roles = [];

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
     * @ORM\OneToOne(targetEntity=Identity::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     * @Assert\Valid()
     */
    private Identity $identity;

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
}
