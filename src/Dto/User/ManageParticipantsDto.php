<?php

namespace App\Dto\User;

class ManageParticipantsDto
{
    public function __construct(
        public array $ids,
    ) {}
}
