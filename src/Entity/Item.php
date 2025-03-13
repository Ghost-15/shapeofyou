<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
class Item
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\ManyToOne(inversedBy: 'items')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'items')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    /**
     * @var Collection<int, Outfit>
     */
    #[ORM\ManyToMany(targetEntity: Outfit::class, mappedBy: 'item')]
    private Collection $outfits;

    /**
     * @var Collection<int, DressHistory>
     */
    #[ORM\ManyToMany(targetEntity: DressHistory::class, mappedBy: 'item')]
    private Collection $dressHistories;

    #[ORM\ManyToOne(inversedBy: 'item')]
    private ?SuggestionIA $suggestionIA = null;

    public function __construct()
    {
        $this->outfits = new ArrayCollection();
        $this->dressHistories = new ArrayCollection();
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

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Outfit>
     */
    public function getOutfits(): Collection
    {
        return $this->outfits;
    }

    public function addOutfit(Outfit $outfit): static
    {
        if (!$this->outfits->contains($outfit)) {
            $this->outfits->add($outfit);
            $outfit->addItem($this);
        }

        return $this;
    }

    public function removeOutfit(Outfit $outfit): static
    {
        if ($this->outfits->removeElement($outfit)) {
            $outfit->removeItem($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, DressHistory>
     */
    public function getDressHistories(): Collection
    {
        return $this->dressHistories;
    }

    public function addDressHistory(DressHistory $dressHistory): static
    {
        if (!$this->dressHistories->contains($dressHistory)) {
            $this->dressHistories->add($dressHistory);
            $dressHistory->addItem($this);
        }

        return $this;
    }

    public function removeDressHistory(DressHistory $dressHistory): static
    {
        if ($this->dressHistories->removeElement($dressHistory)) {
            $dressHistory->removeItem($this);
        }

        return $this;
    }

    public function getSuggestionIA(): ?SuggestionIA
    {
        return $this->suggestionIA;
    }

    public function setSuggestionIA(?SuggestionIA $suggestionIA): static
    {
        $this->suggestionIA = $suggestionIA;

        return $this;
    }
}
