<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Exclude;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    
    private ?string $designation = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateCreation = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateEvent = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $datefinEvenet = null;

    #[ORM\Column(nullable: true)]
    private ?bool $statutevent = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(length: 255)]
    private ?string $nombreticket = null;

    #[ORM\OneToMany(mappedBy: 'event', targetEntity: Ticket::class)]
    private Collection $ticket;

    #[ORM\Column(length: 255)]
    private ?string $codeevent = null;

    #[ORM\ManyToOne(inversedBy: 'eventtypeticket')]
    private ?TypeTicket $typeTicket = null;

    #[ORM\OneToMany(mappedBy: 'typeticketperconcert', targetEntity: TypeTicket::class)]
    private Collection $typeTickets;

    public function __construct()
    {
        $this->ticket = new ArrayCollection();
        $this->typeTickets = new ArrayCollection();
    }

     
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(?string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(?\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getDateEvent(): ?\DateTimeInterface
    {
        return $this->dateEvent;
    }

    public function setDateEvent(?\DateTimeInterface $dateEvent): self
    {
        $this->dateEvent = $dateEvent;

        return $this;
    }

    public function getDatefinEvenet(): ?\DateTimeInterface
    {
        return $this->datefinEvenet;
    }

    public function setDatefinEvenet(\DateTimeInterface $datefinEvenet): self
    {
        $this->datefinEvenet = $datefinEvenet;

        return $this;
    }

    public function isStatutevent(): ?bool
    {
        return $this->statutevent;
    }

    public function setStatutevent(?bool $statutevent): self
    {
        $this->statutevent = $statutevent;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getNombreticket(): ?string
    {
        return $this->nombreticket;
    }

    public function setNombreticket(string $nombreticket): self
    {
        $this->nombreticket = $nombreticket;

        return $this;
    }

    /**
     * @return Collection<int, Ticket>
     */
    public function getTicket(): Collection
    {
        return $this->ticket;
    }

    public function addTicket(Ticket $ticket): self
    {
        if (!$this->ticket->contains($ticket)) {
            $this->ticket->add($ticket);
            $ticket->setEvent($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): self
    {
        if ($this->ticket->removeElement($ticket)) {
            // set the owning side to null (unless already changed)
            if ($ticket->getEvent() === $this) {
                $ticket->setEvent(null);
            }
        }

        return $this;
    }

    public function getCodeevent(): ?string
    {
        return $this->codeevent;
    }

    public function setCodeevent(string $codeevent): self
    {
        $this->codeevent = $codeevent;

        return $this;
    }

    public function getTypeTicket(): ?TypeTicket
    {
        return $this->typeTicket;
    }

    public function setTypeTicket(?TypeTicket $typeTicket): self
    {
        $this->typeTicket = $typeTicket;

        return $this;
    }

    /**
     * @return Collection<int, TypeTicket>
     */
    public function getTypeTickets(): Collection
    {
        return $this->typeTickets;
    }

    public function addTypeTicket(TypeTicket $typeTicket): self
    {
        if (!$this->typeTickets->contains($typeTicket)) {
            $this->typeTickets->add($typeTicket);
            $typeTicket->setTypeticketperconcert($this);
        }

        return $this;
    }

    public function removeTypeTicket(TypeTicket $typeTicket): self
    {
        if ($this->typeTickets->removeElement($typeTicket)) {
            // set the owning side to null (unless already changed)
            if ($typeTicket->getTypeticketperconcert() === $this) {
                $typeTicket->setTypeticketperconcert(null);
            }
        }

        return $this;
    }

 
}
