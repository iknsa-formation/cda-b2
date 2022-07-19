<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $email;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;



    #[ORM\Column(type: 'string', length: 40)]
    private $firstname;

    #[ORM\Column(type: 'string', length: 40)]
    private $lastname;

    #[ORM\Column(type: 'string', length: 43)]
    private $screenname;



    #[ORM\Column(type: 'date')]
    private $birthday;

    /**
     * M: Male
     * F: Female
     * N: Neither
     */
    #[ORM\Column(type: 'string', length: 1)]
    private $gender = "N";

    #[ORM\Column(type: 'string', length: 5)]
    private $locale = "en";

    #[ORM\Column(type: 'datetime')]
    private $registrationAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $lastConnectionAt;

    #[ORM\Column(type: 'integer')]
    private $connectionCounter = 0;

    #[ORM\Column(type: 'boolean')]
    private $isActive = true;

    #[ORM\Column(type: 'boolean')]
    private $isDeleted = false;

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
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
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

    public function addRole(string $role): self
    {
        $this->roles[] = $role;

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
        $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getScreenname(): ?string
    {
        return $this->screenname;
    }

    #[ORM\PrePersist]
    public function setScreenname(): self
    {
        $this->screenname = $this->firstname;               // "John"
        $this->screenname.= " ";                            // "John "
        $this->screenname.= substr($this->lastname, 0, 1);  // "John D"
        $this->screenname.= ".";                            // "John D."

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    public function getRegistrationAt(): ?\DateTimeInterface
    {
        return $this->registrationAt;
    }

    #[ORM\PrePersist]
    public function setRegistrationAt(): self
    {
        $this->registrationAt = new \DateTime;

        return $this;
    }

    public function getLastConnectionAt(): ?\DateTimeInterface
    {
        return $this->lastConnectionAt;
    }

    public function setLastConnectionAt(?\DateTimeInterface $lastConnectionAt): self
    {
        $this->lastConnectionAt = $lastConnectionAt;

        return $this;
    }

    public function getConnectionCounter(): ?int
    {
        return $this->connectionCounter;
    }

    public function setConnectionCounter(int $connectionCounter): self
    {
        $this->connectionCounter = $connectionCounter;

        return $this;
    }

    public function isIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function isIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(bool $isDeleted): self
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }
}
