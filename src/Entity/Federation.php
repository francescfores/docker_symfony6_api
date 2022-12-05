<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FederationRepository")
 */
class Federation implements  JsonSerializable
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
    private $tradeName;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mobile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $addressNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $addressBlock;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $addressPostalCode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $addressCity;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $addressProvince;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $addressCountry;
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="federations")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Business", mappedBy="federation")
     */
    private $businesses;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Module", mappedBy="federations")
     */
    private $modules;

//    /**
//     * @ORM\OneToMany(targetEntity="App\Entity\Game", mappedBy="federation")
//     */
//    private $games;

    /**
     * @ORM\OneToMany(targetEntity=Award::class, mappedBy="federation")
     */
    private $awards;

    /**
     * @ORM\OneToMany(targetEntity=ClientAward::class, mappedBy="federation")
     */
    private $client_awards;
    /**
     * @ORM\Column(type="float", scale=2)
     */
    private $point_by_amount;

    /**
     * @ORM\OneToMany(targetEntity=Notification::class, mappedBy="federation")
     */
    private $notifications;

    /**
     * @ORM\Column(type="float", scale=2)
     */
    private $totalPoints;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lat;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lng;

    /**
     * @ORM\Column(type="float", scale=2)
     */
    private $totalTrans;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $img;

    /**
     * @ORM\OneToMany(targetEntity=Discounts::class, mappedBy="federation")
     */
    private $discounts;
    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->businesses = new ArrayCollection();
        $this->modules = new ArrayCollection();
//        $this->games = new ArrayCollection();
        $this->awards = new ArrayCollection();
        $this->notifications = new ArrayCollection();
        $this->client_awards = new ArrayCollection();
        $this->discounts = new ArrayCollection();
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

    public function getTradeName(): ?string
    {
        return $this->tradeName;
    }

    public function setTradeName(string $tradeName): self
    {
        $this->tradeName = $tradeName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(string $mobile): self
    {
        $this->mobile = $mobile;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

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
            'email' => $this->email,
            'tradeName' => $this->email,
            'mobile'  => $this->mobile,
            'phone'  => $this->phone,
            'pointByAmount'  => $this->point_by_amount,
            'awards'  => $this->getAwards()->toArray(),
            'lng'  => $this->lng,
            'lat'  => $this->lat,
            'totalTrans'  => $this->totalTrans,
            'totalPoints'  => $this->totalPoints,
            'address'  => $this->address,
            'addressNumber'  => $this->addressNumber,
            'addressBlock'  => $this->addressBlock,
            'addressCity'  => $this->addressCity,
            'addressCountry'  => $this->addressCountry,
            'addressPostalCode'  => $this->addressPostalCode,
            'addressProvince'  => $this->addressProvince,
            'img' => $this->img,
            'discounts'  => $this->getDiscounts(),

//            'business'  => $this->getBusinesses()->toArray(),
        ];
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addFederation($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeFederation($this);
        }

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
            $business->setFederation($this);
        }

        return $this;
    }

    public function removeBusiness(Business $business): self
    {
        if ($this->businesses->contains($business)) {
            $this->businesses->removeElement($business);
            // set the owning side to null (unless already changed)
            if ($business->getFederation() === $this) {
                $business->setFederation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Module[]
     */
    public function getModules(): Collection
    {
        return $this->modules;
    }

    public function addModule(Module $module): self
    {
        if (!$this->modules->contains($module)) {
            $this->modules[] = $module;
            $module->addFederation($this);
        }

        return $this;
    }

    public function removeModule(Module $module): self
    {
        if ($this->modules->contains($module)) {
            $this->modules->removeElement($module);
            $module->removeFederation($this);
        }

        return $this;
    }

//    /**
//     * @return Collection|Game[]
//     */
//    public function getGames(): Collection
//    {
//        return $this->games;
//    }
//
//    public function addGame(Game $game): self
//    {
//        if (!$this->games->contains($game)) {
//            $this->games[] = $game;
//            $game->setFederation($this);
//        }
//
//        return $this;
//    }
//
//    public function removeGame(Game $game): self
//    {
//        if ($this->games->contains($game)) {
//            $this->games->removeElement($game);
//            // set the owning side to null (unless already changed)
//            if ($game->getFederation() === $this) {
//                $game->setFederation(null);
//            }
//        }
//
//        return $this;
//    }

    /**
     * @return Collection|Award[]
     */
    public function getAwards(): Collection
    {
        return $this->awards;
    }

    public function addAward(Award $award): self
    {
        if (!$this->awards->contains($award)) {
            $this->awards[] = $award;
            $award->setFederation($this);
        }

        return $this;
    }

    public function removeAward(Award $award): self
    {
        if ($this->awards->contains($award)) {
            $this->awards->removeElement($award);
            // set the owning side to null (unless already changed)
            if ($award->getFederation() === $this) {
                $award->setFederation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ClientAward[]
     */
    public function getClientAward(): Collection
    {
        return $this->client_awards;
    }

    public function addClientAward(ClientAward $award): self
    {
        if (!$this->client_awards->contains($award)) {
            $this->client_awards[] = $award;
            $award->setFederation($this);
        }

        return $this;
    }

    public function removeClientAward(ClientAward $award): self
    {
        if ($this->client_awards->contains($award)) {
            $this->client_awards->removeElement($award);
            // set the owning side to null (unless already changed)
            if ($award->getFederation() === $this) {
                $award->setFederation(null);
            }
        }

        return $this;
    }
    public function getPointByAmount(): ?float
    {
        return $this->point_by_amount;
    }

    public function setPointByAmount(float $point_by_amount): self
    {
        $this->point_by_amount = $point_by_amount;

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
            $notification->setFederation($this);
        }

        return $this;
    }

    public function removeNotification(Notification $notification): self
    {
        if ($this->notifications->contains($notification)) {
            $this->notifications->removeElement($notification);
            // set the owning side to null (unless already changed)
            if ($notification->getFederation() === $this) {
                $notification->setFederation(null);
            }
        }

        return $this;
    }

    public function getTotalPoints(): ?float
    {
        return $this->totalPoints;
    }

    public function setTotalPoints(float $totalPoints): self
    {
        $this->totalPoints = $totalPoints;

        return $this;
    }

    public function getLat(): ?string
    {
        return $this->lat;
    }

    public function setLat(string $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLng(): ?string
    {
        return $this->lng;
    }

    public function setLng(string $lng): self
    {
        $this->lng = $lng;

        return $this;
    }

    public function getTotalTrans(): ?float
    {
        return $this->totalTrans;
    }

    public function setTotalTrans(float $totalTrans): self
    {
        $this->totalTrans = $totalTrans;

        return $this;
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

    public function getAddressNumber(): ?string
    {
        return $this->addressNumber;
    }

    public function setAddressNumber(string $addressNumber): self
    {
        $this->addressNumber = $addressNumber;

        return $this;
    }

    public function getAddressBlock(): ?string
    {
        return $this->addressBlock;
    }

    public function setAddressBlock(?string $addressBlock): self
    {
        $this->addressBlock = $addressBlock;

        return $this;
    }

    public function getAddressPostalCode(): ?string
    {
        return $this->addressPostalCode;
    }

    public function setAddressPostalCode(string $addressPostalCode): self
    {
        $this->addressPostalCode = $addressPostalCode;

        return $this;
    }

    public function getAddressCity(): ?string
    {
        return $this->addressCity;
    }

    public function setAddressCity(string $addressCity): self
    {
        $this->addressCity = $addressCity;

        return $this;
    }

    public function getAddressProvince(): ?string
    {
        return $this->addressProvince;
    }

    public function setAddressProvince(string $addressProvince): self
    {
        $this->addressProvince = $addressProvince;

        return $this;
    }

    public function getAddressCountry(): ?string
    {
        return $this->addressCountry;
    }

    public function setAddressCountry(string $addressCountry): self
    {
        $this->addressCountry = $addressCountry;

        return $this;
    }

    /**
     * @return Collection|Discounts[]
     */
    public function getDiscounts(): Collection
    {
        return $this->discounts;
    }

    public function addDiscount(Discounts $discount): self
    {
        if (!$this->discounts->contains($discount)) {
            $this->discounts[] = $discount;
            $discount->setFederation($this);
        }

        return $this;
    }

    public function removeDiscount(Discounts $discount): self
    {
        if ($this->discounts->removeElement($discount)) {
            // set the owning side to null (unless already changed)
            if ($discount->getFederation() === $this) {
                $discount->setFederation(null);
            }
        }

        return $this;
    }
}
