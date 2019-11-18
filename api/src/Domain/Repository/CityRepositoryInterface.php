<?php

namespace App\Domain\Repository;

use App\Domain\Entity\CityInterface;

interface CityRepositoryInterface
{
    public function getCityByNameAndZipCode(string $name, string $zipCode): ?CityInterface;
}
