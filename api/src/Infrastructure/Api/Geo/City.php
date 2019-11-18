<?php

namespace App\Infrastructure\Api\Geo;

use App\Domain\Entity\CityInterface;

class City implements CityInterface
{
    private $name;
    private $zipCode;

    public function __construct(string $name, string $zipCode)
    {
        $this->name = $name;
        $this->zipCode = $zipCode;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getZipCode(): string
    {
        return $this->zipCode;
    }
}
