<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TransactionRepository")
 */
class Transaction implements  JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float", scale=2)
     */
    private $total;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $location;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="transactions", cascade={"persist", "remove"})
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Business", inversedBy="transactions", cascade={"persist", "remove"})
     */
 
    private $business;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Game", inversedBy="transactions")
     */
    private $games;

    /**
     * @ORM\Column(type="datetime", length=255)
     */
    private $date;

    /**
     * @ORM\OneToOne(targetEntity=Ticket::class, mappedBy="transaction", cascade={"remove"})
     */
    private $ticket;

    /**
     * @ORM\Column(type="float")
     */
    private $points;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $time;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getBusiness(): ?Business
    {
        return $this->business;
    }

    public function setBusiness(?Business $business): self
    {
        $this->business = $business;

        return $this;
    }

    public function getGames(): ?Game
    {
        return $this->games;
    }

    public function setGames(?Game $games): self
    {
        $this->games = $games;

        return $this;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'total' => $this->total,
            'date' => $this->date,
            'date_string'=>$this->date->format("d/m/Y H:i"),
            'location'  => $this->location,
            'ticket'  => $this->getTicket(),
            'business'  => $this->getBusiness(),
            'client'  => $this->getClient(),
            'game'  => $this->getGames(),
            'points'  => $this->points,
            'status'  => $this->status,
//            'federations'  => $this->federations->toArray(),
        ];
    }

    public function getTicket(): ?Ticket
    {
        return $this->ticket;
    }

    public function setTicket(?Ticket $ticket): self
    {
        $this->ticket = $ticket;

        // set (or unset) the owning side of the relation if necessary
        $newTransaction = null === $ticket ? null : $this;
        if ($ticket->getTransaction() !== $newTransaction) {
            $ticket->setTransaction($newTransaction);
        }

        return $this;
    }

    public function getPoints(): ?float
    {
        return $this->points;
    }

    public function setPoints(float $points): self
    {
        $this->points = $points;

        return $this;
    }

    public function getTime(): ?string
    {
        return $this->time;
    }

    public function setTime(string $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }
}
