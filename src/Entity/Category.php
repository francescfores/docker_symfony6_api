<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category implements JsonSerializable
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
     * @ORM\ManyToMany(targetEntity=Business::class, mappedBy="categories")
     */
    private $businesses;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $img;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=SubCat::class, mappedBy="category", cascade={"remove"})
     */
    private $subCats;

    public function __construct()
    {
        $this->businesses = new ArrayCollection();
        $this->subCats = new ArrayCollection();
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
            $business->addCategory($this);
        }

        return $this;
    }

    public function removeBusiness(Business $business): self
    {
        if ($this->businesses->contains($business)) {
            $this->businesses->removeElement($business);
            $business->removeCategory($this);
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
            'description' => $this->description,
//            'img' => base64_decode($this->img),
            'img' => $this->img,
//            'subcategory' => $this->subCats->toArray(),
        ];
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): self
    {
        $this->img = $img;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|SubCat[]
     */
    public function getSubCats(): Collection
    {
        return $this->subCats;
    }

    public function addSubCat(SubCat $subCat): self
    {
        if (!$this->subCats->contains($subCat)) {
            $this->subCats[] = $subCat;
            $subCat->setCategory($this);
        }

        return $this;
    }

    public function removeSubCat(SubCat $subCat): self
    {
        if ($this->subCats->contains($subCat)) {
            $this->subCats->removeElement($subCat);
            // set the owning side to null (unless already changed)
            if ($subCat->getCategory() === $this) {
                $subCat->setCategory(null);
            }
        }

        return $this;
    }
}
