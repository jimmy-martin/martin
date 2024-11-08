<?php

namespace App\Dto\Party;

use App\Dto\Address\UpdateAddressDto;

class UpdatePartyDto
{
    public function __construct(
        public int $id,
        public string $name,
        public \DateTimeImmutable $date,
        public int $maxParticipants,
        public bool $isFree,
        public ?float $price,
        public int $typeId,
        public UpdateAddressDto $address,
    ) {}
}
