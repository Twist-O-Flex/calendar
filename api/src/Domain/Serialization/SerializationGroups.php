<?php

namespace App\Domain\Serialization;

final class SerializationGroups
{
    public const COMPETITION_ITEM_READ = 'competition:item:read';
    public const COMPETITION_COLLECTION_READ = 'competition:collection:read';
    public const COMPETITION_READ = [
        self::COMPETITION_ITEM_READ,
        self::COMPETITION_COLLECTION_READ,
    ];

    public const CLUB_ITEM_READ = 'club:item:read';
    public const CLUB_COLLECTION_READ = 'club:collection:read';
    public const CLUB_READ = [
        self::CLUB_ITEM_READ,
        self::CLUB_COLLECTION_READ,
    ];

    public const COLLECTION_READ = [
        self::COMPETITION_COLLECTION_READ,
        self::CLUB_COLLECTION_READ,
    ];

    public const ITEM_READ = [
        self::COMPETITION_ITEM_READ,
        self::CLUB_ITEM_READ,
    ];

    public const READ = [
        self::COMPETITION_ITEM_READ,
        self::COMPETITION_COLLECTION_READ,
        self::CLUB_ITEM_READ,
        self::CLUB_COLLECTION_READ,
    ];
}
