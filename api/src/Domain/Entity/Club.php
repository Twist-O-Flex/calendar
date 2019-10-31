<?php

namespace App\Domain\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use App\Domain\Serialization\SerializationGroups;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     collectionOperations={
 *          "get"={
 *              "normalization_context"={"groups"={SerializationGroups::CLUB_COLLECTION_READ}}
 *          },
 *          "post"={"security"="is_granted('ROLE_EDITOR')"}
 *      },
 *     itemOperations={
 *          "get"={
 *              "normalization_context"={"groups"={SerializationGroups::CLUB_ITEM_READ}}
 *          },
 *          "put"={"security"="is_granted('ROLE_EDITOR')"}
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
     *
     * @Assert\NotNull
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\Embedded(class="App\Domain\Entity\Address")
     *
     * @Groups(SerializationGroups::ITEM_READ)
     *
     * @Assert\NotNull
     * @Assert\Valid
     */
    private $address;

    /**
     * @ORM\Embedded(class="App\Domain\Entity\Contact")
     *
     * @Groups(SerializationGroups::ITEM_READ)
     *
     * @Assert\NotNull
     * @Assert\Valid
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

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function setAddress(Address $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getContact(): Contact
    {
        return $this->contact;
    }

    public function setContact(Contact $contact): self
    {
        $this->contact = $contact;

        return $this;
    }
}
