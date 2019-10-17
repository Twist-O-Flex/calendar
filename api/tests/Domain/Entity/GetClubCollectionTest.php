<?php

namespace App\Tests\Domain\Entity;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

class GetClubCollectionTest extends ApiTestCase
{
    public function testGetCollection(): void
    {
        $response = static::createClient()->request('GET', '/clubs');

        $this->assertResponseIsSuccessful();
        $this->assertJson($response->getContent());
    }
}
