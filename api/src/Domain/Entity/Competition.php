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
 *      collectionOperations={
 *          "get"={
 *              "normalization_context"={"groups"={SerializationGroups::COMPETITION_COLLECTION_READ}}
 *          }
 *      },
 *      itemOperations={
 *          "get"={
 *              "normalization_context"={"groups"={SerializationGroups::COMPETITION_ITEM_READ}}
 *          }
 *      }
 * )
 * @ORM\Entity
 * @ORM\Table(name="competition")
 */
class Competition
{
    public const TYPE_TOURNAMENT = 'tournament';
    public const TYPE_CHAMPIONSHIP = 'championship';
    public const TYPE_GRAND_PRIX = 'grand_prix';
    public const TYPE_CHALLENGE = 'challenge';
    public const TYPE_NATIONAL = 'national';
    public const TYPE_INTERCLUB = 'interclub';
    public const ALL_TYPES = [
        self::TYPE_TOURNAMENT,
        self::TYPE_CHAMPIONSHIP,
        self::TYPE_GRAND_PRIX,
        self::TYPE_CHALLENGE,
        self::TYPE_CHALLENGE,
        self::TYPE_NATIONAL,
        self::TYPE_INTERCLUB,
    ];

    public const FORMATION_TAT = 'tat';
    public const FORMATION_DOU = 'dou';
    public const FORMATION_TRI = 'tri';
    public const ALL_FORMATIONS = [
        self::FORMATION_TAT,
        self::FORMATION_DOU,
        self::FORMATION_TRI,
    ];

    public const QUOTATION_PRO = 'pro';
    public const QUOTATION_TC = 'tc';
    public const QUOTATION_MIXTE = 'mixte';
    public const ALL_QUOTATIONS = [
        self::QUOTATION_PRO,
        self::QUOTATION_TC,
        self::QUOTATION_MIXTE
    ];

    public const MIN_DURATION = 1;

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
     * @Groups(SerializationGroups::COMPETITION_READ)
     *
     * @Assert\Choice(Competition::ALL_TYPES)
     */
    private $type;

    /**
     * @ORM\Column(type="string")
     *
     * @Groups(SerializationGroups::COMPETITION_READ)
     *
     * @Assert\Choice(Competition::ALL_FORMATIONS)
     */
    private $formation;

    /**
     * @ORM\ManyToOne(targetEntity="Club")
     * @ORM\JoinColumn(name="club_id", referencedColumnName="id")
     *
     * @Groups(SerializationGroups::COMPETITION_READ)
     *
     * @Assert\NotBlank
     * @Assert\Type("string")
     */
    private $club;

    /**
     * @ORM\Column(type="date_immutable")
     *
     * @Groups(SerializationGroups::COMPETITION_READ)
     *
     * @Assert\DateTime
     */
    private $startDate;

    /**
     * @ORM\Column(type="integer")
     *
     * @Groups(SerializationGroups::COMPETITION_READ)
     *
     * @Assert\Type("integer")
     * @Assert\GreaterThanOrEqual(Competition::MIN_DURATION)
     */
    private $duration;

    /**
     * @ORM\Column(type="string")
     *
     * @Groups(SerializationGroups::COMPETITION_READ)
     *
     * @Assert\Choice(Competition::ALL_QUOTATIONS)
     */
    private $quotation;

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getFormation(): string
    {
        return $this->formation;
    }

    public function getClub(): Club
    {
        return $this->club;
    }

    public function getStartDate(): \DateTimeImmutable
    {
        return $this->startDate;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function getQuotation(): string
    {
        return $this->quotation;
    }
}
