<?php

namespace App\Dto\Party;

use App\Dto\Address\CreateAddressDto;

class CreatePartyDto
{
    public function __construct(
        public string $name,
        public \DateTimeImmutable $date,
        public int $maxParticipants,
        public bool $isFree,
        public ?float $price,
        public int $typeId,
        public CreateAddressDto $address,
        public int $createdById,
    ) {}
}
