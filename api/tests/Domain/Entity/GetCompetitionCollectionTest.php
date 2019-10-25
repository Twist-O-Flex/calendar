<?php

namespace App\Tests\Domain\Entity;

use App\Tests\ApiTestCase;

class GetCompetitionCollectionTest extends ApiTestCase
{
    public function testSchema(): void
    {
        $response = static::createClient()->request('GET', '/competitions?itemsPerPage=3');

        $this->assertResponseIsSuccessful();
        $this->assertJson($content = $response->getContent());

        $content = \Safe\json_decode($content, true);
        $this->assertArrayHasKey("@context", $content);
        $this->assertArrayHasKey("@id", $content);
        $this->assertArrayHasKey("@type", $content);
        $this->assertArrayHasKey("hydra:totalItems", $content);
        $this->assertArrayHasKey("hydra:view", $content);

        foreach ($content["hydra:member"] as $competition) {
            $this->assertArrayHasKey("@id", $competition);
            $this->assertArrayHasKey("@type", $competition);
            $this->assertArrayHasKey("id", $competition);
            $this->assertArrayHasKey("type", $competition);
            $this->assertArrayHasKey("formation", $competition);

            $this->assertArrayHasKey("club", $competition);
            $this->assertArrayHasKey("@id", $competition['club']);
            $this->assertArrayHasKey("@type", $competition['club']);
            $this->assertArrayHasKey("id", $competition['club']);
            $this->assertArrayHasKey("name", $competition['club']);
            $this->assertSame(4, count($competition['club']));

            $this->assertArrayHasKey("startDate", $competition);
            $this->assertArrayHasKey("duration", $competition);
            $this->assertArrayHasKey("quotation", $competition);
        }

        $this->assertSame(3, count($content["hydra:member"]));
    }
}
