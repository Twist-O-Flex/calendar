<?php

namespace App\Domain\Entity;

use App\Domain\Serialization\SerializationGroups;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Embeddable
 */
class City implements CityInterface
{
    /**
     * @ORM\Column(type="string")
     *
     * @Groups(SerializationGroups::READ)
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     *
     * @Groups(SerializationGroups::READ)
     */
    private $zipCode;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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
}
