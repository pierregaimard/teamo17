<?php

namespace App\Entity;

use App\Repository\UserRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    const ROLE_ADMIN = "ROLE_ADMIN";
    const ROLE_CUSTOMER_ADMIN = "ROLE_CUSTOMER_ADMIN";
    const ROLE_USER = "ROLE_USER";

    #[ORM\Id]
    #[ORM\GeneratedValue]

    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string|null The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    /**
     * @var string|null Used for reset password flow
     */
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $passwordToken = null;

    /**
     * @var DateTimeInterface|null Used for reset password flow
     */
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $passwordTokenExpiration = null;

    public function getId(): ?int
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
    public function getUserIdentifier(): string
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
     * @see PasswordAuthenticatedUserInterface
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
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getPasswordToken(): ?string
    {
        return $this->passwordToken;
    }

    public function setPasswordToken(?string $passwordToken): self
    {
        $this->passwordToken = $passwordToken;

        return $this;
    }

    public function getPasswordTokenExpiration(): ?DateTimeInterface
    {
        return $this->passwordTokenExpiration;
    }

    public function setPasswordTokenExpiration(?DateTimeInterface $passwordTokenExpiration): self
    {
        $this->passwordTokenExpiration = $passwordTokenExpiration;

        return $this;
    }
}
