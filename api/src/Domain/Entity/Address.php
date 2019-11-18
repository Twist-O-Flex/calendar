<?php

namespace App\Domain\Entity;

use App\Domain\Serialization\SerializationGroups;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Embeddable
 */
class Address
{
    /**
     * @ORM\Embedded(class="App\Domain\Entity\City")
     *
     * @Groups(SerializationGroups::READ)
     */
    private $city;

    /**
     * @ORM\Column(type="string")
     *
     * @Groups(SerializationGroups::ITEM_READ)
     */
    private $street;

    public function getCity(): City
    {
        return $this->city;
    }

    public function setCity(City $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }
}
