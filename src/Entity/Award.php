<?php

namespace App\Entity;

use App\Repository\AwardRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\BlobType;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass=AwardRepository::class)
 */
class Award implements JsonSerializable
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="awards")
     * @ORM\JoinColumn(nullable=true)
     */
    private $client;

    /**
     * @ORM\Column(type="integer")
     */
    private $points;

    /**
     * @ORM\Column(type="integer")
     */
    private $stock;

    /**
     * @ORM\ManyToOne(targetEntity=Federation::class, inversedBy="awards")
     */
    private $federation;

    /**
     * @ORM\OneToMany(targetEntity=ClientAward::class, mappedBy="award", cascade={"remove"}))
     */
    private $clientAwards;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=Business::class, inversedBy="awards")
     * @ORM\JoinColumn(nullable=true)
     */
    private $business;

    /**
     * @ORM\Column(type="string", length=1024)
     */
    private $img;

    /**
     * @ORM\OneToMany(targetEntity=Notification::class, mappedBy="award", cascade={"remove"})
     */
    private $notifications;

    /**
     * @ORM\Column(type="integer")
     */
    private $intervalDay;

    public function __construct()
    {
        $this->clientAwards = new ArrayCollection();
        $this->notifications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }



    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(int $points): self
    {
        $this->points = $points;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

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
            'description' => $this->description,
            'points' => $this->points,
            'stock' => $this->stock,
            'img' => $this->img,
            'interval_days' => $this->intervalDay,
            //'img' => $this->img,
            /*'business'  => $this->getBusiness(),*/
           /* 'federation'  => $this->getFederation(),*/
        ];
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

    /**
     * @return Collection|ClientAward[]
     */
    public function getClientAwards(): Collection
    {
        return $this->clientAwards;
    }

    public function addClientAward(ClientAward $clientAward): self
    {
        if (!$this->clientAwards->contains($clientAward)) {
            $this->clientAwards[] = $clientAward;
            $clientAward->setAward($this);
        }

        return $this;
    }

    public function removeClientAward(ClientAward $clientAward): self
    {
        if ($this->clientAwards->contains($clientAward)) {
            $this->clientAwards->removeElement($clientAward);
            // set the owning side to null (unless already changed)
            if ($clientAward->getAward() === $this) {
                $clientAward->setAward(null);
            }
        }

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

    public function getBusiness(): ?Business
    {
        return $this->business;
    }

    public function setBusiness(?Business $business): self
    {
        $this->business = $business;

        return $this;
    }

    public function getImg()
    {
        return $this->img;
    }

    public function setImg($img): self
    {
        $this->img = $img;

        return $this;
    }

    /**
     * @return Collection|Notification[]
     */
    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

    public function addNotification(Notification $notification): self
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications[] = $notification;
            $notification->setAward($this);
        }

        return $this;
    }

    public function removeNotification(Notification $notification): self
    {
        if ($this->notifications->contains($notification)) {
            $this->notifications->removeElement($notification);
            // set the owning side to null (unless already changed)
            if ($notification->getAward() === $this) {
                $notification->setAward(null);
            }
        }

        return $this;
    }

    public function getIntervalDay(): ?int
    {
        return $this->intervalDay;
    }

    public function setIntervalDay(int $intervalDay): self
    {
        $this->intervalDay = $intervalDay;

        return $this;
    }

}
