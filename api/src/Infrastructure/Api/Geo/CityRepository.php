<?php

namespace App\Infrastructure\Api\Geo;

use App\Domain\Entity\CityInterface;
use App\Domain\Repository\CityRepositoryInterface;

class CityRepository extends GeoRepository implements CityRepositoryInterface
{
    public function getCityByNameAndZipCode(string $name, string $zipCode): ?CityInterface
    {
        $response = $this->httpClient->request(
            "GET",
            "{$this->uri}/communes?" . \http_build_query(["nom" => $name, "codePostal" => $zipCode])
        );

        if (empty($content = \Safe\json_decode($response->getContent(), true))) {
            return null;
        }

        if (\count($content) > 1) {
            throw new \DomainException("More than 1 city found with name: $name and zip code: $zipCode");
        }

        return new City($content[0]["nom"], $content[0]["codesPostaux"][0]);
    }
}
