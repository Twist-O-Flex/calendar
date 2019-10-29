<?php

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Serialization\SerializationGroups;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Embeddable
 */
class Address
{
    /**
     * @ORM\Column(type = "string")
     *
     * @Groups(SerializationGroups::ITEM_READ)
     *
     * @Assert\Type("string")
     * @Assert\NotBlank
     */
    private $city;

    /**
     * @ORM\Column(type = "string")
     *
     * @Groups(SerializationGroups::ITEM_READ)
     *
     * @Assert\Type("string")
     * @Assert\NotBlank
     */
    private $zipCode;

    /**
     * @ORM\Column(type = "string")
     *
     * @Groups(SerializationGroups::ITEM_READ)
     *
     * @Assert\Type("string")
     * @Assert\NotBlank
     */
    private $street;

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): self
    {
        $this->zipCode = $zipCode;

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
