<?php

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Serialization\SerializationGroups;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Embeddable
 */
class Address
{
    /**
     * @ORM\Column(type = "string")
     *
     * @Groups(SerializationGroups::ITEM_READ)
     */
    private $city;

    /**
     * @ORM\Column(type = "string")
     *
     * @Groups(SerializationGroups::ITEM_READ)
     */
    private $zipCode;

    /**
     * @ORM\Column(type = "string")
     *
     * @Groups(SerializationGroups::ITEM_READ)
     */
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
