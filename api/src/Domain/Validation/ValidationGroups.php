<?php

namespace App\Domain\Validation;

final class ValidationGroups
{
    public const CLUB_POST = 'club:post';
    public const CLUB_PUT = 'club:put';
    public const CLUB_WRITE = [self::CLUB_POST, self::CLUB_PUT];

    public const COMPETITION_POST = 'competition:post';
    public const COMPETITION_PUT = 'competition:put';
    public const COMPETITION_WRITE = [self::COMPETITION_POST, self::COMPETITION_PUT];
}
