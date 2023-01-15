<?php

namespace App\Entity;

use App\Repository\TypeTicketRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeTicketRepository::class)]
class TypeTicket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $designation = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $price = null;

    #[ORM\Column(length: 255)]
    private ?string $statutticket = null;

    #[ORM\OneToMany(mappedBy: 'typeticket', targetEntity: Ticket::class)]
    private Collection $tickets;

    #[ORM\Column(length: 255)]
    private ?string $nombretotal = null;

    #[ORM\ManyToOne(inversedBy: 'typeTickets')]
    private ?Event $typeticketperconcert = null;

   

    public function __construct()
    {
        $this->tickets = new ArrayCollection();
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

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getStatutticket(): ?string
    {
        return $this->statutticket;
    }

    public function setStatutticket(string $statutticket): self
    {
        $this->statutticket = $statutticket;

        return $this;
    }

    /**
     * @return Collection<int, Ticket>
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): self
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets->add($ticket);
            $ticket->setTypeticket($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): self
    {
        if ($this->tickets->removeElement($ticket)) {
            // set the owning side to null (unless already changed)
            if ($ticket->getTypeticket() === $this) {
                $ticket->setTypeticket(null);
            }
        }

        return $this;
    }

    public function getNombretotal(): ?string
    {
        return $this->nombretotal;
    }

    public function setNombretotal(string $nombretotal): self
    {
        $this->nombretotal = $nombretotal;

        return $this;
    }

    public function getTypeticketperconcert(): ?Event
    {
        return $this->typeticketperconcert;
    }

    public function setTypeticketperconcert(?Event $typeticketperconcert): self
    {
        $this->typeticketperconcert = $typeticketperconcert;

        return $this;
    }

    
}
