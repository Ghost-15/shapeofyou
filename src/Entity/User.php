<?php

namespace App\Entity;

use App\Enum\GenderStatus;
use App\Enum\HeightStatus;
use App\Enum\MorphologyStatus;
use App\Enum\WeightStatus;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $profil_picture = null;

    #[ORM\Column(enumType: GenderStatus::class)]
    private ?GenderStatus $gender = null;

    #[ORM\Column(nullable: true, enumType: HeightStatus::class)]
    private ?HeightStatus $height = null;

    #[ORM\Column(nullable: true, enumType: WeightStatus::class)]
    private ?WeightStatus $weight = null;

    #[ORM\Column(nullable: true, enumType: MorphologyStatus::class)]
    private ?MorphologyStatus $morphology = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\OneToMany(targetEntity: Item::class, mappedBy: 'user')]
    private Collection $items;

    /**
     * @var Collection<int, Notification>
     */
    #[ORM\OneToMany(targetEntity: Notification::class, mappedBy: 'user')]
    private Collection $notifications;

    /**
     * @var Collection<int, SuggestionIA>
     */
    #[ORM\OneToMany(targetEntity: SuggestionIA::class, mappedBy: 'user')]
    private Collection $suggestionIAs;

    #[ORM\Column]
    private bool $isVerified = false;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->notifications = new ArrayCollection();
        $this->suggestionIAs = new ArrayCollection();
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

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

    public function getProfilPicture(): ?string
    {
        return $this->profil_picture;
    }

    public function setProfilPicture(?string $profil_picture): static
    {
        $this->profil_picture = $profil_picture;

        return $this;
    }

    public function getGender(): ?GenderStatus
    {
        return $this->gender;
    }

    public function setGender(?GenderStatus $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getHeight(): ?HeightStatus
    {
        return $this->height;
    }

    public function setHeight(?HeightStatus $height): static
    {
        $this->height = $height;

        return $this;
    }

    public function getWeight(): ?WeightStatus
    {
        return $this->weight;
    }

    public function setWeight(?WeightStatus $weight): static
    {
        $this->weight = $weight;

        return $this;
    }

    public function getMorphology(): ?MorphologyStatus
    {
        return $this->morphology;
    }

    public function setMorphology(?MorphologyStatus $morphology): static
    {
        $this->morphology = $morphology;

        return $this;
    }

    /**
     * @return Collection<int, Item>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Item $item): static
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setUser($this);
        }

        return $this;
    }

    public function removeItem(Item $item): static
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getUser() === $this) {
                $item->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Notification>
     */
    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

    public function addNotification(Notification $notification): static
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications->add($notification);
            $notification->setUser($this);
        }

        return $this;
    }

    public function removeNotification(Notification $notification): static
    {
        if ($this->notifications->removeElement($notification)) {
            // set the owning side to null (unless already changed)
            if ($notification->getUser() === $this) {
                $notification->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SuggestionIA>
     */
    public function getSuggestionIAs(): Collection
    {
        return $this->suggestionIAs;
    }

    public function addSuggestionIA(SuggestionIA $suggestionIA): static
    {
        if (!$this->suggestionIAs->contains($suggestionIA)) {
            $this->suggestionIAs->add($suggestionIA);
            $suggestionIA->setUser($this);
        }

        return $this;
    }

    public function removeSuggestionIA(SuggestionIA $suggestionIA): static
    {
        if ($this->suggestionIAs->removeElement($suggestionIA)) {
            // set the owning side to null (unless already changed)
            if ($suggestionIA->getUser() === $this) {
                $suggestionIA->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }
}
