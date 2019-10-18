<?php

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class Address
{
    /** @ORM\Column(type = "string") */
    private $city;

    /** @ORM\Column(type = "string") */
    private $zipCode;

    /** @ORM\Column(type = "string") */
    private $street;

    public function getCity(): string
    {
        return $this->city;
    }

    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    public function getStreet(): string
    {
        return $this->street;
    }
}
