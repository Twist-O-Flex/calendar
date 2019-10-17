<?php

namespace App\Tests\Domain\Entity;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

class GetClubItemTest extends ApiTestCase
{
    public function testGetItem(): void
    {
        $response = static::createClient()->request('GET', '/clubs/df9fcbae-c6ff-11e8-a8d5-f2801f1b9fd1');

        $this->assertResponseIsSuccessful();
        $this->assertJson($response->getContent());
    }
}
