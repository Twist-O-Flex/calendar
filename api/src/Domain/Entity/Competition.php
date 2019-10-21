<?php

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

/**
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

    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $type;

    /**
     * @ORM\Column(type="string")
     */
    private $formation;

    /**
     * @ORM\ManyToOne(targetEntity="Club")
     * @ORM\JoinColumn(name="club_id", referencedColumnName="id")
     */
    private $club;

    /**
     * @ORM\Column(type="date_immutable")
     */
    private $startDate;

    /**
     * @ORM\Column(type="integer")
     */
    private $duration;

    /**
     * @ORM\Column(type="string")
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