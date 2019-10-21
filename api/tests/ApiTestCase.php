<?php

namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test;

class ApiTestCase extends Test\ApiTestCase
{
    public static function assertMatchesJsonSchema($jsonSchema, ?int $checkMode = null, string $message = ''): void
    {
        parent::assertMatchesJsonSchema(
            \Safe\file_get_contents(__DIR__ . "/../schema/$jsonSchema.json"),
            $checkMode,
            $message
        );
    }
}
