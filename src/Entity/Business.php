<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BusinessRepository")
 */
class Business implements  JsonSerializable
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
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
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
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="businesses")
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Federation", inversedBy="businesses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $federation;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Client", inversedBy="businesses")
     */
    private $clients;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $location;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="business")
     */
    private $transactions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Promotion", mappedBy="business")
     */
    private $promotions;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Route", mappedBy="businesses")
     */
    private $routes;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, inversedBy="businesses")
     */
    private $categories;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nif;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $img;

    /**
     * @ORM\ManyToOne(targetEntity=SubCat::class, inversedBy="businesses")
     */
    private $subcategory;

    /**
     * @ORM\OneToMany(targetEntity=Award::class, mappedBy="business", cascade={"remove"})
     */
    private $awards;

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
     * @ORM\OneToMany(targetEntity=Notification::class, mappedBy="business")
     */
    private $notifications;

    /**
     * @ORM\Column(type="float", scale=2)
     */
    private $totalPoints;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lat;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lng;

    /**
     * @ORM\Column(type="float", scale=2)
     */
    private $totalTrans;

    /**
     * @ORM\OneToMany(targetEntity=ClientAward::class, mappedBy="business")
     */
    private $clientAwards;

    /**
     * @ORM\OneToMany(targetEntity=Rating::class, mappedBy="business", orphanRemoval=true)
     */
    private $ratings;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $punctuation;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $TotalPunctuation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=Discounts::class, mappedBy="businesses")
     */
    private $discounts;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $url_web;


    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->clients = new ArrayCollection();
        $this->transactions = new ArrayCollection();
        $this->promotions = new ArrayCollection();
        $this->routes = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->awards = new ArrayCollection();
        $this->notifications = new ArrayCollection();
        $this->clientAwards = new ArrayCollection();
        $this->ratings = new ArrayCollection();
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

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'desc' => $this->description,
            'description' => $this->description,
            'url' => $this->url_web,
            'email' => $this->email,
            'mobile'  => $this->mobile,
            'phone'  => $this->phone,
            'address'  => $this->address,
            'addressNumber'  => $this->addressNumber,
            'addressBlock'  => $this->addressBlock,
            'addressCity'  => $this->addressCity,
            'addressCountry'  => $this->addressCountry,
            'addressPostalCode'  => $this->addressPostalCode,
            'addressProvince'  => $this->addressProvince,
            'location'  => $this->location,
            //'img' => base64_decode($this->img),
            'img' => $this->img,
            'federation'  => $this->getFederation(),
            'clients'  => $this->getClients()->toArray(),
            'subcategory'  => $this->getSubcategory(),
            'awards'  => $this->getAwards()->toArray(),
            'awardsDelivered'  => $this->getClientAwards()->toArray(),
            'nif'  => $this->nif,
            'category'  => $this->getCategories()->toArray(),
            'totalPoints'  => $this->getTotalPoints(),
            'totalTrans'  => $this->getTotalTrans(),
            'lat'  => $this->getLat(),
            'lng'  => $this->getLng(),
            'punctuation'  => $this->getPunctuation(),
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
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
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
        }

        return $this;
    }

    public function removeClient(Client $client): self
    {
        if ($this->clients->contains($client)) {
            $this->clients->removeElement($client);
        }

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

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
            $transaction->setBusiness($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->contains($transaction)) {
            $this->transactions->removeElement($transaction);
            // set the owning side to null (unless already changed)
            if ($transaction->getBusiness() === $this) {
                $transaction->setBusiness(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Promotion[]
     */
    public function getPromotions(): Collection
    {
        return $this->promotions;
    }

    public function addPromotion(Promotion $promotion): self
    {
        if (!$this->promotions->contains($promotion)) {
            $this->promotions[] = $promotion;
            $promotion->setBusiness($this);
        }

        return $this;
    }

    public function removePromotion(Promotion $promotion): self
    {
        if ($this->promotions->contains($promotion)) {
            $this->promotions->removeElement($promotion);
            // set the owning side to null (unless already changed)
            if ($promotion->getBusiness() === $this) {
                $promotion->setBusiness(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Route[]
     */
    public function getRoutes(): Collection
    {
        return $this->routes;
    }

    public function addRoute(Route $route): self
    {
        if (!$this->routes->contains($route)) {
            $this->routes[] = $route;
            $route->addBusiness($this);
        }

        return $this;
    }

    public function removeRoute(Route $route): self
    {
        if ($this->routes->contains($route)) {
            $this->routes->removeElement($route);
            $route->removeBusiness($this);
        }

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
        }

        return $this;
    }

    public function getNif(): ?string
    {
        return $this->nif;
    }

    public function setNif(string $nif): self
    {
        $this->nif = $nif;

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

    public function getSubcategory(): ?SubCat
    {
        return $this->subcategory;
    }

    public function setSubcategory(?SubCat $subcategory): self
    {
        $this->subcategory = $subcategory;

        return $this;
    }

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
            $award->setBusiness($this);
        }

        return $this;
    }

    public function removeAward(Award $award): self
    {
        if ($this->awards->contains($award)) {
            $this->awards->removeElement($award);
            // set the owning side to null (unless already changed)
            if ($award->getBusiness() === $this) {
                $award->setBusiness(null);
            }
        }

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
            $notification->setBusiness($this);
        }

        return $this;
    }

    public function removeNotification(Notification $notification): self
    {
        if ($this->notifications->contains($notification)) {
            $this->notifications->removeElement($notification);
            // set the owning side to null (unless already changed)
            if ($notification->getBusiness() === $this) {
                $notification->setBusiness(null);
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
            $clientAward->setBusiness($this);
        }

        return $this;
    }

    public function removeClientAward(ClientAward $clientAward): self
    {
        if ($this->clientAwards->contains($clientAward)) {
            $this->clientAwards->removeElement($clientAward);
            // set the owning side to null (unless already changed)
            if ($clientAward->getBusiness() === $this) {
                $clientAward->setBusiness(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Rating[]
     */
    public function getRatings(): Collection
    {
        return $this->ratings;
    }

    public function addRating(Rating $rating): self
    {
        if (!$this->ratings->contains($rating)) {
            $this->ratings[] = $rating;
            $rating->setBusiness($this);
        }

        return $this;
    }

    public function removeRating(Rating $rating): self
    {
        if ($this->ratings->contains($rating)) {
            $this->ratings->removeElement($rating);
            // set the owning side to null (unless already changed)
            if ($rating->getBusiness() === $this) {
                $rating->setBusiness(null);
            }
        }

        return $this;
    }

    public function getPunctuation(): ?float
    {
        return $this->punctuation;
    }

    public function setPunctuation(?float $punctuation): self
    {
        $this->punctuation = $punctuation;

        return $this;
    }

    public function getTotalPunctuation(): ?float
    {
        return $this->TotalPunctuation;
    }

    public function setTotalPunctuation(?float $TotalPunctuation): self
    {
        $this->TotalPunctuation = $TotalPunctuation;

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
            $discount->addBusiness($this);
        }

        return $this;
    }

    public function removeDiscount(Discounts $discount): self
    {
        if ($this->discounts->removeElement($discount)) {
            $discount->removeBusiness($this);
        }

        return $this;
    }

    public function getUrlWeb(): ?string
    {
        return $this->url_web;
    }

    public function setUrlWeb(?string $url_web): self
    {
        $this->url_web = $url_web;

        return $this;
    }

}
