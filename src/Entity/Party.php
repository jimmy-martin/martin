<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PartyRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PartyRepository::class)]
#[ORM\Index(name: 'idx_party_date', columns: ['date'])]
#[ApiResource]
class Party
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date = null;

    #[ORM\Column]
    private ?int $maxParticipants = null;

    #[ORM\Column]
    private ?bool $isFree = null;

    #[ORM\Column(nullable: true)]
    private ?float $price = null;

    #[ORM\ManyToOne(inversedBy: 'parties')]
    #[ORM\JoinColumn(nullable: true)]
    private ?PartyType $type = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Address $address = null;

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

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getMaxParticipants(): ?int
    {
        return $this->maxParticipants;
    }

    public function setMaxParticipants(int $maxParticipants): static
    {
        $this->maxParticipants = $maxParticipants;

        return $this;
    }

    public function isFree(): ?bool
    {
        return $this->isFree;
    }

    public function setFree(bool $isFree): static
    {
        $this->isFree = $isFree;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getType(): ?PartyType
    {
        return $this->type;
    }

    public function setType(?PartyType $type): static
    {
        $this->type = $type;

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
}
