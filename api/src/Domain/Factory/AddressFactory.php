<?php

namespace App\Domain\Factory;

use App\Domain\DTO\AddressInput;
use App\Domain\Entity\Address;

class AddressFactory
{
    private $cityFactory;

    public function __construct(CityFactory $cityFactory)
    {
        $this->cityFactory = $cityFactory;
    }

    public function fromAddressInput(AddressInput $addressInput): Address
    {
        return (new Address())
            ->setStreet($addressInput->street)
            ->setCity($this->cityFactory->fromCityInput($addressInput->city));
    }
}
