<?php

namespace App\Dto\User;

use Rekalogika\Mapper\Attribute\Eager;

#[Eager]
class UserDtoLight
{
    public function __construct(
        public int $id,
        public string $email,
        public string $name,
    ) {}
}
