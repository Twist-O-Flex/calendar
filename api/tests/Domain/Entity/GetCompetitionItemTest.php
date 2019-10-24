<?php

namespace App\Tests\Domain\Entity;

use App\Tests\ApiTestCase;

class GetCompetitionItemTest extends ApiTestCase
{
    public function testSchema(): void
    {
        $response = static::createClient()->request('GET', '/competitions/7d853409-ff26-4097-826e-e1f78f5a5a01');

        $this->assertResponseIsSuccessful();
        $this->assertJson($response->getContent());
    }
}
