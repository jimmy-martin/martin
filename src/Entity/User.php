<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[ApiResource]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?int $age = null;

    #[ORM\Column(nullable: true)]
    private ?float $averageRating = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Address $address = null;

    /**
     * @var Collection<int, Party>
     */
    #[ORM\ManyToMany(targetEntity: Party::class, mappedBy: 'participants')]
    private Collection $attendingParties;

    /**
     * @var Collection<int, Party>
     */
    #[ORM\OneToMany(targetEntity: Party::class, mappedBy: 'createdBy', orphanRemoval: true)]
    private Collection $createdParties;

    /**
     * @var Collection<int, Interest>
     */
    #[ORM\ManyToMany(targetEntity: Interest::class)]
    private Collection $interests;

    public function __construct()
    {
        $this->attendingParties = new ArrayCollection();
        $this->createdParties = new ArrayCollection();
        $this->interests = new ArrayCollection();
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
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

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getAverageRating(): ?float
    {
        return $this->averageRating;
    }

    public function setAverageRating(?float $averageRating): static
    {
        $this->averageRating = $averageRating;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): static
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Collection<int, Party>
     */
    public function getAttendingParties(): Collection
    {
        return $this->attendingParties;
    }

    public function addAttendingParty(Party $attendingParty): static
    {
        if (!$this->attendingParties->contains($attendingParty)) {
            $this->attendingParties->add($attendingParty);
            $attendingParty->addParticipant($this);
        }

        return $this;
    }

    public function removeAttendingParty(Party $attendingParty): static
    {
        if ($this->attendingParties->removeElement($attendingParty)) {
            $attendingParty->removeParticipant($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Party>
     */
    public function getCreatedParties(): Collection
    {
        return $this->createdParties;
    }

    public function addCreatedParty(Party $createdParty): static
    {
        if (!$this->createdParties->contains($createdParty)) {
            $this->createdParties->add($createdParty);
            $createdParty->setCreatedBy($this);
        }

        return $this;
    }

    public function removeCreatedParty(Party $createdParty): static
    {
        if ($this->createdParties->removeElement($createdParty)) {
            // set the owning side to null (unless already changed)
            if ($createdParty->getCreatedBy() === $this) {
                $createdParty->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Interest>
     */
    public function getInterests(): Collection
    {
        return $this->interests;
    }

    public function addInterest(Interest $interest): static
    {
        if (!$this->interests->contains($interest)) {
            $this->interests->add($interest);
        }

        return $this;
    }

    public function removeInterest(Interest $interest): static
    {
        $this->interests->removeElement($interest);

        return $this;
    }
}
