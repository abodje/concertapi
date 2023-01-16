<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
class Ticket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $codesecret = null;

    #[ORM\Column(length: 255)]
    private ?string $codevisuel = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dategeneration = null;

    #[ORM\Column(length: 255)]
    private ?string $price = null;

    #[ORM\OneToMany(mappedBy: 'ticket', targetEntity: Event::class)]
    private Collection $events;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    private ?TypeTicket $typeticket = null;

    #[ORM\ManyToOne(inversedBy: 'ticket')]
    private ?Event $event = null;

    #[ORM\Column(nullable: true)]
    private ?bool $statutrentrer = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $daterentrer = null;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    private ?User $userquiabadger = null;

    public function __construct()
    {
        $this->events = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodesecret(): ?string
    {
        return $this->codesecret;
    }

    public function setCodesecret(?string $codesecret): self
    {
        $this->codesecret = $codesecret;

        return $this;
    }

    public function getCodevisuel(): ?string
    {
        return $this->codevisuel;
    }

    public function setCodevisuel(string $codevisuel): self
    {
        $this->codevisuel = $codevisuel;

        return $this;
    }

    public function getDategeneration(): ?\DateTimeInterface
    {
        return $this->dategeneration;
    }

    public function setDategeneration(\DateTimeInterface $dategeneration): self
    {
        $this->dategeneration = $dategeneration;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

 

    public function getTypeticket(): ?TypeTicket
    {
        return $this->typeticket;
    }

    public function setTypeticket(?TypeTicket $typeticket): self
    {
        $this->typeticket = $typeticket;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;

        return $this;
    }

    public function isStatutrentrer(): ?bool
    {
        return $this->statutrentrer;
    }

    public function setStatutrentrer(?bool $statutrentrer): self
    {
        $this->statutrentrer = $statutrentrer;

        return $this;
    }

    public function getStatutrentrer(): bool
    {
 
        return $this->statutrentrer;
    }

    public function getDaterentrer(): ?\DateTimeInterface
    {
        return $this->daterentrer;
    }

    public function setDaterentrer(?\DateTimeInterface $daterentrer): self
    {
        $this->daterentrer = $daterentrer;

        return $this;
    }

    public function getUserquiabadger(): ?User
    {
        return $this->userquiabadger;
    }

    public function setUserquiabadger(?User $userquiabadger): self
    {
        $this->userquiabadger = $userquiabadger;

        return $this;
    }
}
