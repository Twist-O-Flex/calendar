<?php

namespace App\Application\DataTransformer\Club\Traits;

use App\Domain\DTO\ClubInput;
use App\Domain\Repository\CityRepositoryInterface;

trait HydrateClubInputTrait
{
    /** @var CityRepositoryInterface */
    private $cityRepository;

    public function hydrateCity(ClubInput $clubInput): void
    {
        /* Retrieve clean city data from API Geo */
        $cityInput = $clubInput->address->city;
        $city = $this->cityRepository->getCityByNameAndZipCode($cityInput->name, $cityInput->zipCode);

        $clubInput->address->city->name = $city->getName();
        $clubInput->address->city->zipCode = $city->getZipCode();
    }
}
