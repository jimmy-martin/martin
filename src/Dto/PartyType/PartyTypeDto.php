<?php

namespace App\Dto\PartyType;

use Rekalogika\Mapper\Attribute\Eager;

#[Eager]
class PartyTypeDto
{
    public function __construct(
        public int $id,
        public string $name,
    ) {}
}
