<?php

namespace App\Domain\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Domain\DTO\CompetitionInput;
use App\Domain\Serialization\SerializationGroups;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     input=CompetitionInput::class,
 *     collectionOperations={
 *         "get" = {
 *             "normalization_context" = {"groups" = {SerializationGroups::COMPETITION_COLLECTION_READ}}
 *         },
 *         "post" = {"security" = "is_granted('ROLE_EDITOR')"}
 *     },
 *     itemOperations={
 *         "get" = {
 *             "normalization_context" = {"groups" = {SerializationGroups::COMPETITION_ITEM_READ}}
 *         },
 *         "put" = {"security" = "is_granted('ROLE_EDITOR')"}
 *     }
 * )
 * @ORM\Entity
 * @ORM\Table(
 *     name="competition",
 *     indexes={
 *         @ORM\Index(name="type_idx", columns={"type"}),
 *         @ORM\Index(name="formation_idx", columns={"formation"}),
 *         @ORM\Index(name="club_idx", columns={"club_id"}),
 *         @ORM\Index(name="quotation_idx", columns={"quotation"}),
 *         @ORM\Index(name="quotation_formation_idx", columns={"quotation", "formation"}),
 *         @ORM\Index(name="type_formation_idx", columns={"type", "formation"}),
 *         @ORM\Index(name="type_formation_quotation_idx", columns={"type", "formation", "quotation"}),
 *         @ORM\Index(name="type_formation_club_idx", columns={"type", "formation", "club_id"}),
 *         @ORM\Index(name="type_formation_quotation_club_idx", columns={"type", "formation", "quotation", "club_id"})
 *     }
 * )
 * @ApiFilter(
 *     SearchFilter::class,
 *     properties={"type" = "exact", "formation" = "exact", "club.id" = "exact", "quotation" = "exact"}
 * )
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
     */
    private $type;

    /**
     * @ORM\Column(type="string")
     *
     * @Groups(SerializationGroups::COMPETITION_READ)
     */
    private $formation;

    /**
     * @ORM\ManyToOne(targetEntity="Club")
     * @ORM\JoinColumn(name="club_id", referencedColumnName="id")
     *
     * @Groups(SerializationGroups::COMPETITION_READ)
     */
    private $club;

    /**
     * @ORM\Column(type="datetimetz_immutable")
     *
     * @Groups(SerializationGroups::COMPETITION_READ)
     */
    private $startDate;

    /**
     * Duration in day(s)
     *
     * @ORM\Column(type="integer")
     *
     * @Groups(SerializationGroups::COMPETITION_READ)
     */
    private $duration;

    /**
     * @ORM\Column(type="string")
     *
     * @Groups(SerializationGroups::COMPETITION_READ)
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

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getFormation(): string
    {
        return $this->formation;
    }

    public function setFormation(string $formation): self
    {
        $this->formation = $formation;

        return $this;
    }

    public function getClub(): Club
    {
        return $this->club;
    }

    public function setClub(Club $club): self
    {
        $this->club = $club;

        return $this;
    }

    public function getStartDate(): \DateTimeImmutable
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeImmutable $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getQuotation(): string
    {
        return $this->quotation;
    }

    public function setQuotation(string $quotation): self
    {
        $this->quotation = $quotation;

        return $this;
    }
}
