<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameRepository")
 */
class Game  implements  JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dateStart;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dateEnd;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="games")
     */
    private $transactions;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Client", mappedBy="games")
     */
    private $clients;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Federation", inversedBy="games")
     */
    private $federation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Gymkhana", mappedBy="game", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="gymkhana_id", referencedColumnName="id", onDelete="CASCADE")
     */

    private $gymkhana;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\GameType", inversedBy="games")
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\GameState", inversedBy="games")
     */
    private $state;


    public function __construct()
    {
        $this->transactions = new ArrayCollection();
        $this->clients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDateStart(): ?string
    {
        return $this->dateStart;
    }

    public function setDateStart(string $dateStart): self
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function getDateEnd(): ?string
    {
        return $this->dateEnd;
    }

    public function setDateEnd(string $dateEnd): self
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): self
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions[] = $transaction;
            $transaction->setGames($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->contains($transaction)) {
            $this->transactions->removeElement($transaction);
            // set the owning side to null (unless already changed)
            if ($transaction->getGames() === $this) {
                $transaction->setGames(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Client[]
     */
    public function getClients(): Collection
    {
        return $this->clients;
    }

    public function addClient(Client $client): self
    {
        if (!$this->clients->contains($client)) {
            $this->clients[] = $client;
            $client->addGame($this);
        }

        return $this;
    }

    public function removeClient(Client $client): self
    {
        if ($this->clients->contains($client)) {
            $this->clients->removeElement($client);
            $client->removeGame($this);
        }

        return $this;
    }

    public function getFederation(): ?Federation
    {
        return $this->federation;
    }

    public function setFederation(?Federation $federation): self
    {
        $this->federation = $federation;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->getType(),
            'description'  => $this->description,
            'dateStart'  => $this->dateStart,
            'dateEnd'  => $this->dateEnd,
            'state'  => $this->getState(),
            'federation'  => $this->getFederation(),
            'gymkhana'  => $this->gymkhana,
//            'federations'  => $this->federations->toArray(),
        ];
    }

    public function getGymkhana(): ?Gymkhana
    {
        return $this->gymkhana;
    }

    public function setGymkhana(Gymkhana $gymkhana): self
    {
        $this->gymkhana = $gymkhana;

        // set the owning side of the relation if necessary
        if ($gymkhana->getGame() !== $this) {
            $gymkhana->setGame($this);
        }

        return $this;
    }

    public function getType(): ?GameType
    {
        return $this->type;
    }

    public function setType(?GameType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getState(): ?GameState
    {
        return $this->state;
    }

    public function setState(?GameState $state): self
    {
        $this->state = $state;
        return $this;
    }

}
