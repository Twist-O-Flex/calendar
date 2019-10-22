<?php

namespace App\Tests\Domain\Entity;

use App\Tests\ApiTestCase;

class GetClubCollectionTest extends ApiTestCase
{
    public function testSchema(): void
    {
        $response = static::createClient()->request('GET', '/clubs?itemsPerPage=3');

        $this->assertResponseIsSuccessful();
        $this->assertJson($response->getContent());
        $this->assertMatchesJsonSchema('getClubCollection');
    }
}
