<?php

namespace App\Dto\Address;

use Rekalogika\Mapper\Attribute\Eager;

#[Eager]
class UpdateAddressDto
{
    public function __construct(
        public int $id,
        public string $street,
        public string $postalCode,
        public string $city,
        public string $region,
        public string $country,
    ) {}
}
