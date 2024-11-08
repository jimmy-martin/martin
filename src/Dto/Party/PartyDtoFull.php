<?php

namespace App\Dto\Party;

use App\Dto\Address\AddressDto;
use App\Dto\PartyType\PartyTypeDto;
use App\Dto\User\UserDtoLight;
use Rekalogika\Mapper\Attribute\Eager;

#[Eager]
class PartyDtoFull
{
    /**
     * @param UserDtoLight[] $participants
     */
    public function __construct(
        public int $id,
        public string $name,
        public ?\DateTimeImmutable $date,
        public int $maxParticipants,
        public bool $isFree,
        public ?float $price,
        public PartyTypeDto $type,
        public AddressDto $address,
        public array $participants,
        public UserDtoLight $createdBy,
    ) {}
}
