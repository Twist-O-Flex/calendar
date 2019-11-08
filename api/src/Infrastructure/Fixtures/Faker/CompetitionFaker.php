<?php

namespace App\Infrastructure\Fixtures\Faker;

use App\Domain\Entity\Competition;
use Faker\Provider\Base;

final class CompetitionFaker extends Base
{
    public static function randomCompetitionType(): string
    {
        return Competition::ALL_TYPES[\array_rand(Competition::ALL_TYPES)];
    }

    public static function randomCompetitionFormation(): string
    {
        return Competition::ALL_FORMATIONS[\array_rand(Competition::ALL_FORMATIONS)];
    }

    public static function randomQuotation(): string
    {
        return Competition::ALL_QUOTATIONS[\array_rand(Competition::ALL_QUOTATIONS)];
    }
}
