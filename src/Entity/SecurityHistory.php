<?php

namespace App\Entity;

use App\Repository\SecurityHistoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SecurityHistoryRepository::class)]
class SecurityHistory
{
    const ON_LOGIN_SUCCESS_EVENT = 'LoginSuccess';
    const ON_LOGOUT_EVENT = 'Logout';
    const ON_AUTHENTICATION_FAILURE_EVENT = 'AuthenticationFailure';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\Column(type: 'string', length: 255)]
    private $event;

    #[ORM\Column(type: 'datetime_immutable')]
    private $eventAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getEvent(): ?string
    {
        return $this->event;
    }

    public function setEvent(string $event): self
    {
        $this->event = $event;

        return $this;
    }

    public function getEventAt(): ?\DateTimeImmutable
    {
        return $this->eventAt;
    }

    public function setEventAt(\DateTimeImmutable $eventAt): self
    {
        $this->eventAt = $eventAt;

        return $this;
    }
}
