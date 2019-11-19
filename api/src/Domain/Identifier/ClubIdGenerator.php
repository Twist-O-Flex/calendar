<?php

namespace App\Domain\Identifier;

use App\Domain\DTO\ClubInput;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class ClubIdGenerator
{
    private const NAMESPACE = 'cd417f88-86b6-4584-a9f3-bfc64e8d444e';

    public function fromClubInput(ClubInput $clubInput): UuidInterface
    {
        $city = $clubInput->address->city;

        return Uuid::uuid5(
            self::NAMESPACE,
            "{$clubInput->name}:{$clubInput->address->street}:{$city->name}:{$city->zipCode}"
        );
    }
}
