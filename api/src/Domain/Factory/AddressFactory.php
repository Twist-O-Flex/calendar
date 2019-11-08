<?php

namespace App\Domain\Factory;

use App\Domain\DTO\AddressInput;
use App\Domain\Entity\Address;

class AddressFactory
{
    public function fromAddressInput(AddressInput $addressInput): Address
    {
        return (new Address())
            ->setStreet($addressInput->street)
            ->setCity($addressInput->city)
            ->setZipCode($addressInput->zipCode)
        ;
    }
}
