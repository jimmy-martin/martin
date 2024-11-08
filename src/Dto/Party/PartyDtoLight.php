<?php

namespace App\Dto\Party;

use App\Dto\Address\AddressDto;
use App\Dto\PartyType\PartyTypeDto;
use Rekalogika\Mapper\Attribute\Eager;

#[Eager]
class PartyDtoLight
{
    public function __construct(
        public int $id,
        public string $name,
        public ?\DateTimeImmutable $date,
        public int $maxParticipants,
        public bool $isFree,
        public ?float $price,
        public PartyTypeDto $type,
        public AddressDto $address,
    ) {}
}
