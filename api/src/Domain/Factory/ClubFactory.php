<?php

namespace App\Domain\Factory;

use App\Domain\DTO\ClubInput;
use App\Domain\Entity\Club;

class ClubFactory
{
    private $contactFactory;
    private $addressFactory;

    public function __construct(ContactFactory $contactFactory, AddressFactory $addressFactory)
    {
        $this->contactFactory = $contactFactory;
        $this->addressFactory = $addressFactory;
    }

    public function fromClubInput(ClubInput $clubInput): Club
    {
        return (new Club())
            ->setName($clubInput->name)
            ->setContact($this->contactFactory->fromContactInput($clubInput->contact))
            ->setAddress($this->addressFactory->fromAddressInput($clubInput->address));
    }
}
