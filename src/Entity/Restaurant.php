<?php

namespace App\Entity;

use App\Repository\RestaurantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RestaurantRepository::class)]
class Restaurant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTime $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'restaurants')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ville $ville = null;

    #[ORM\ManyToOne(inversedBy: 'restaurants')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var Collection<int, RestaurantPicture>
     */
    #[ORM\OneToMany(targetEntity: RestaurantPicture::class, mappedBy: 'restaurant')]
    private Collection $restaurantPictures;

    /**
     * @var Collection<int, Avis>
     */
    #[ORM\OneToMany(targetEntity: Avis::class, mappedBy: 'restaurant')]
    private Collection $avis;

    #[ORM\ManyToOne(inversedBy: 'avis')]
    private ?Avis $child = null;

    public function __construct()
    {
        $this->restaurantPictures = new ArrayCollection();
        $this->avis = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getVille(): ?Ville
    {
        return $this->ville;
    }

    public function setVille(?Ville $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, RestaurantPicture>
     */
    public function getRestaurantPictures(): Collection
    {
        return $this->restaurantPictures;
    }

    public function addRestaurantPicture(RestaurantPicture $restaurantPicture): static
    {
        if (!$this->restaurantPictures->contains($restaurantPicture)) {
            $this->restaurantPictures->add($restaurantPicture);
            $restaurantPicture->setRestaurant($this);
        }

        return $this;
    }

    public function removeRestaurantPicture(RestaurantPicture $restaurantPicture): static
    {
        if ($this->restaurantPictures->removeElement($restaurantPicture)) {
            // set the owning side to null (unless already changed)
            if ($restaurantPicture->getRestaurant() === $this) {
                $restaurantPicture->setRestaurant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Avis>
     */
    public function getAvis(): Collection
    {
        return $this->avis;
    }

    public function addAvi(Avis $avi): static
    {
        if (!$this->avis->contains($avi)) {
            $this->avis->add($avi);
            $avi->setRestaurant($this);
        }

        return $this;
    }

    public function removeAvi(Avis $avi): static
    {
        if ($this->avis->removeElement($avi)) {
            // set the owning side to null (unless already changed)
            if ($avi->getRestaurant() === $this) {
                $avi->setRestaurant(null);
            }
        }

        return $this;
    }

    public function getChild(): ?Avis
    {
        return $this->child;
    }

    public function setChild(?Avis $child): static
    {
        $this->child = $child;

        return $this;
    }
}
