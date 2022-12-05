<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RouteRepository")
 */
class Route implements  JsonSerializable
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
    private $prize;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prizeNumber;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Gymkhana", inversedBy="routes")
     * @ORM\JoinColumn(name="gymkhana_id", referencedColumnName="id", onDelete="CASCADE")
     * @ORM\JoinColumn(nullable=false)
     */
    private $gymkhana;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Business", inversedBy="routes")
     */
    private $businesses;

    public function __construct()
    {
        $this->businesses = new ArrayCollection();
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

    public function getPrize(): ?string
    {
        return $this->prize;
    }

    public function setPrize(string $prize): self
    {
        $this->prize = $prize;

        return $this;
    }

    public function getPrizeNumber(): ?string
    {
        return $this->prizeNumber;
    }

    public function setPrizeNumber(string $prizeNumber): self
    {
        $this->prizeNumber = $prizeNumber;

        return $this;
    }

    public function getGymkhana(): ?Gymkhana
    {
        return $this->gymkhana;
    }

    public function setGymkhana(?Gymkhana $gymkhana): self
    {
        $this->gymkhana = $gymkhana;

        return $this;
    }

    /**
     * @return Collection|Business[]
     */
    public function getBusinesses(): Collection
    {
        return $this->businesses;
    }

    public function addBusiness(Business $business): self
    {
        if (!$this->businesses->contains($business)) {
            $this->businesses[] = $business;
        }

        return $this;
    }

    public function removeBusiness(Business $business): self
    {
        if ($this->businesses->contains($business)) {
            $this->businesses->removeElement($business);
        }

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
            'prize'  => $this->prize,
            'prizeNumber'  => $this->prizeNumber,
//            'gymkhana' => $this->gymkhana,
            'businesses' => $this->getBusinesses()->toArray(),
        ];
    }
}
