<?php

namespace App\Tests\Domain\Entity;

use App\Tests\ApiTestCase;

class GetClubItemTest extends ApiTestCase
{
    public function testGetItem(): void
    {
        $response = static::createClient()->request('GET', '/clubs/df9fcbae-c6ff-11e8-a8d5-f2801f1b9fd1');

        $this->assertResponseIsSuccessful();
        $this->assertJson($response->getContent());
        $this->assertMatchesJsonSchema('getClubItem');
    }
}
