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

        $content = \Safe\json_decode($response->getContent(), true);

        $this->assertSame("/contexts/Club", $content['@context']);
        $this->assertSame("/clubs", $content["@id"]);
        $this->assertSame("hydra:Collection", $content["@type"]);
        $this->assertArrayHasKey("hydra:totalItems", $content);
        $this->assertArrayHasKey("hydra:view", $content);

        foreach ($content["hydra:member"] as $club) {
            $this->assertArrayHasKey("@id", $club);
            $this->assertArrayHasKey("@type", $club);
            $this->assertArrayHasKey("id", $club);
            $this->assertArrayHasKey("name", $club);
            $this->assertCount(4, $club);
        }

        $this->assertCount(3, $content["hydra:member"]);
    }
}
