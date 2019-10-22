<?php

namespace App\Tests\Domain\Entity;

use App\Tests\ApiTestCase;

class GetCompetitionCollectionTest extends ApiTestCase
{
    public function testSchema(): void
    {
        $response = static::createClient()->request('GET', '/competitions?itemsPerPage=3');

        $this->assertResponseIsSuccessful();
        $this->assertJson($response->getContent());
        $this->assertMatchesJsonSchema('getCompetitionCollection');
    }
}
