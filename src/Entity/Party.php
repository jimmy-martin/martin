<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\QueryParameter;
use App\Dto\Party\CreatePartyDto;
use App\Dto\Party\PartyDtoFull;
use App\Dto\Party\PartyDtoLight;
use App\Dto\Party\UpdatePartyDto;
use App\Dto\User\ManageParticipantsDto;
use App\Repository\PartyRepository;
use App\State\Processor\Party\ManagePartyParticipantsStateProcessor;
use App\State\Processor\Party\PartyStateProcessor;
use App\State\Provider\Party\ReadPartyStateProvider;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: PartyRepository::class)]
#[ORM\Index(name: 'idx_party_date', columns: ['date'])]
#[ApiResource(
    operations: [
        new Get(
            output: PartyDtoFull::class,
            provider: ReadPartyStateProvider::class
        ),
        new Post(
            uriTemplate: '/parties/{id}/add-participants',
            input: ManageParticipantsDto::class,
            output: PartyDtoFull::class,
            name: 'add_participants',
            processor: ManagePartyParticipantsStateProcessor::class
        ),
        new Post(
            uriTemplate: '/parties/{id}/remove-participants',
            input: ManageParticipantsDto::class,
            output: PartyDtoFull::class,
            name: 'remove_participants',
            processor: ManagePartyParticipantsStateProcessor::class
        ),
        new GetCollection(
            uriTemplate: '/parties/search',
            output: PartyDtoLight::class,
            name: 'search_parties',
            provider: ReadPartyStateProvider::class,
            parameters: [
                'city' => new QueryParameter(),
                'type' => new QueryParameter(),
                'maxParticipants' => new QueryParameter(),
                'isFree' => new QueryParameter(),
                'date' => new QueryParameter(),
            ]
        ),
        new GetCollection(
            output: PartyDtoLight::class,
            provider: ReadPartyStateProvider::class
        ),
        new Post(
            input: CreatePartyDto::class,
            output: PartyDtoFull::class,
            processor: PartyStateProcessor::class
        ),
        new Put(
            input: UpdatePartyDto::class,
            output: PartyDtoFull::class,
            processor: PartyStateProcessor::class
        ),
        new Delete(),
    ]
)]
class Party
{
    use TimestampableEntity;

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

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'attendingParties')]
    private Collection $participants;

    #[ORM\ManyToOne(inversedBy: 'createdParties')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $createdBy = null;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
        $this->createdAt = new \DateTime();
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

    public function getIsFree(): ?bool
    {
        return $this->isFree;
    }

    public function setIsFree(bool $isFree): static
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

    /**
     * @return Collection<int, User>
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(User $participant): static
    {
        if (!$this->participants->contains($participant)) {
            $this->participants->add($participant);
        }

        return $this;
    }

    public function removeParticipant(User $participant): static
    {
        $this->participants->removeElement($participant);

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): static
    {
        $this->createdBy = $createdBy;

        return $this;
    }
}
