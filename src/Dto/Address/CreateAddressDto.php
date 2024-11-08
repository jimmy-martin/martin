<?php

namespace App\Dto\Address;

use Rekalogika\Mapper\Attribute\Eager;

#[Eager]
class CreateAddressDto
{
    public function __construct(
        public string $street,
        public string $postalCode,
        public string $city,
        public string $region,
        public string $country,
    ) {}
}
