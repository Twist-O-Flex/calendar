<?php

namespace App\Domain\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use App\Domain\Serialization\SerializationGroups;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     collectionOperations={
 *          "get"={
 *              "normalization_context"={"groups"={SerializationGroups::CLUB_COLLECTION_READ}}
 *          }
 *      },
 *     itemOperations={
 *          "get"={
 *              "normalization_context"={"groups"={SerializationGroups::CLUB_ITEM_READ}}
 *          }
 *     }
 * )
 * @ORM\Entity
 * @ORM\Table(name="club")
 */
class Club
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     *
     * @Groups(SerializationGroups::READ)
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     *
     * @Groups({
     *     SerializationGroups::CLUB_ITEM_READ,
     *     SerializationGroups::CLUB_COLLECTION_READ,
     *     SerializationGroups::COMPETITION_COLLECTION_READ
     * })
     */
    private $name;

    /**
     * @ORM\Embedded(class="App\Domain\Entity\Address")
     *
     * @Groups(SerializationGroups::ITEM_READ)
     */
    private $address;

    /**
     * @ORM\Embedded(class="App\Domain\Entity\Contact")
     *
     * @Groups(SerializationGroups::ITEM_READ)
     */
    private $contact;

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function getContact(): Contact
    {
        return $this->contact;
    }
}
