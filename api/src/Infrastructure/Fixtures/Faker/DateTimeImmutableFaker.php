<?php

namespace App\Infrastructure\Fixtures\Faker;

use Faker\Provider;

class DateTimeImmutableFaker extends Provider\Base
{
    public static function dateTimeImmutableThisMonth($max = 'now', $timezone = null): \DateTimeImmutable
    {
        return \DateTimeImmutable::createFromMutable(Provider\DateTime::dateTimeThisMonth($max, $timezone));
    }
}
