<?php

namespace App\Infrastructure\Fixtures\Faker;

use App\Domain\Entity\Competition;
use App\Domain\Type\CompetitionCategory;
use Faker\Provider\Base;

final class CompetitionFaker extends Base
{
    public static function randomCompetitionCategory(): string
    {
        return CompetitionCategory::ALL[\array_rand(CompetitionCategory::ALL)];
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
