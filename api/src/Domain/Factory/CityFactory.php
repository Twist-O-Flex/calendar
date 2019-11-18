<?php

namespace App\Domain\Factory;

use App\Domain\DTO\CityInput;
use App\Domain\Entity\City;

class CityFactory
{
    public function fromCityInput(CityInput $cityInput): City
    {
        return (new City())
            ->setName($cityInput->name)
            ->setZipCode($cityInput->zipCode);
    }
}
