<?php

namespace App\Entity;

use App\Repository\DressHistoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DressHistoryRepository::class)]
class DressHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var Collection<int, Item>
     */
    #[ORM\ManyToMany(targetEntity: Item::class, inversedBy: 'dressHistories')]
    private Collection $item;

    #[ORM\Column]
    private ?\DateTimeImmutable $consultation_date = null;

    public function __construct()
    {
        $this->item = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Item>
     */
    public function getItem(): Collection
    {
        return $this->item;
    }

    public function addItem(Item $item): static
    {
        if (!$this->item->contains($item)) {
            $this->item->add($item);
        }

        return $this;
    }

    public function removeItem(Item $item): static
    {
        $this->item->removeElement($item);

        return $this;
    }

    public function getConsultationDate(): ?\DateTimeImmutable
    {
        return $this->consultation_date;
    }

    public function setConsultationDate(\DateTimeImmutable $consultation_date): static
    {
        $this->consultation_date = $consultation_date;

        return $this;
    }
}
