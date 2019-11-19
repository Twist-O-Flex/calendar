<?php

namespace App\Domain\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Domain\DTO\ClubInput;
use App\Domain\Serialization\SerializationGroups;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     input=ClubInput::class,
 *     collectionOperations={
 *         "get" = {
 *             "normalization_context" = {"groups" = {SerializationGroups::CLUB_COLLECTION_READ}}
 *         },
 *         "post" = {"security" = "is_granted('ROLE_EDITOR')"}
 *     },
 *     itemOperations={
 *         "get" = {
 *             "normalization_context" = {"groups" = {SerializationGroups::CLUB_ITEM_READ}}
 *         },
 *         "put" = {"security" = "is_granted('ROLE_EDITOR')"}
 *     }
 * )
 * @ApiFilter(
 *     SearchFilter::class,
 *     properties={"name" = "ipartial", "address.city.name" = "istart", "address.city.zipCode" = "start"}
 * )
 * @ORM\Entity
 * @ORM\Table(
 *     name="club",
 *     indexes={
 *         @ORM\Index(name="name_idx", columns={"name"}),
 *         @ORM\Index(name="address_city_name_idx", columns={"address_city_name"}),
 *         @ORM\Index(name="address_city_zip_code_idx", columns={"address_city_zip_code"}),
 *         @ORM\Index(
 *             name="address_city_zip_code_city_name_idx",
 *             columns={"address_city_zip_code", "address_city_name"}
 *         ),
 *     }
 * )
 */
class Club
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="NONE")
     *
     * @Groups(SerializationGroups::READ)
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     *
     * @Groups(SerializationGroups::READ)
     */
    private $name;

    /**
     * @ORM\Embedded(class="App\Domain\Entity\Address")
     *
     * @Groups(SerializationGroups::READ)
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

    public function setId(UuidInterface $id): self
    {
        $this->id = $id;

        return $this;
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
