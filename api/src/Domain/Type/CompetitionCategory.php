<?php

namespace App\Domain\Type;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

final class CompetitionCategory extends AbstractEnumType
{
    public const TOURNAMENT = 'tournament';
    public const CHAMPIONSHIP = 'championship';
    public const GRAND_PRIX = 'grand_prix';
    public const CHALLENGE = 'challenge';
    public const NATIONAL = 'national';
    public const INTERCLUB = 'interclub';

    public const ALL = [
        self::TOURNAMENT,
        self::CHAMPIONSHIP,
        self::GRAND_PRIX,
        self::CHALLENGE,
        self::CHALLENGE,
        self::NATIONAL,
        self::INTERCLUB,
    ];

    protected static $choices = [
        self::TOURNAMENT => 'competition.category.tournament',
        self::CHAMPIONSHIP => 'competition.category.championship',
        self::GRAND_PRIX => 'competition.category.grand_prix',
        self::CHALLENGE => 'competition.category.challenge',
        self::NATIONAL => 'competition.category.national',
        self::INTERCLUB => 'competition.category.interclub',
    ];
}
