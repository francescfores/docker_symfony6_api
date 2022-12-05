<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ModuleRepository")
 */
class Module implements JsonSerializable
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
     * @ORM\Column(type="string", length=255)
     */
    private $price;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Federation", inversedBy="modules")
     */
    private $federations;

    public function __construct()
    {
        $this->federations = new ArrayCollection();
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
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price'  => $this->price,
        ];
    }

    /**
     * @return Collection|Federation[]
     */
    public function getFederations(): Collection
    {
        return $this->federations;
    }

    public function addFederation(Federation $federation): self
    {
        if (!$this->federations->contains($federation)) {
            $this->federations[] = $federation;
        }

        return $this;
    }

    public function removeFederation(Federation $federation): self
    {
        if ($this->federations->contains($federation)) {
            $this->federations->removeElement($federation);
        }

        return $this;
    }
}
