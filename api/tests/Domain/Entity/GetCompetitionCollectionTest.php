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
            $this->assertArrayHasKey("address", $competition['club']);
            $this->assertCount(5, $competition['club']);

            $this->assertArrayHasKey("zipCode", $competition['club']['address']);
            $this->assertArrayHasKey("city", $competition['club']['address']);
            $this->assertCount(2, $competition['club']['address']);

            $this->assertArrayHasKey("startDate", $competition);
            $this->assertArrayHasKey("duration", $competition);
            $this->assertArrayHasKey("quotation", $competition);
        }

        $this->assertCount(3, $content["hydra:member"]);
    }

    /**
     * @dataProvider filterProvider
     */
    public function testFilter(string $filter, bool $shouldBeEmpty, callable $assert = null): void
    {
        $response = $this->getAnonymousClient()->request('GET', "/competitions?itemsPerPage=5&$filter");

        $this->assertResponseIsSuccessful();
        $this->assertJson($content = $response->getContent());

        $content = \Safe\json_decode($content, true);

        if ($shouldBeEmpty) {
            $this->assertEmpty($content["hydra:member"]);

            return;
        }

        $this->assertNotEmpty($content["hydra:member"]);

        foreach ($content["hydra:member"] as $competition) {
            $assert($competition);
        }
    }

    public function filterProvider(): \Generator
    {
        yield "type tournament" => [
            "type=tournament",
            false,
            function (array $competition) {
                $this->assertSame("tournament", $competition['type']);
            }
        ];

        yield "type grand prix" => [
            "type=grand_prix",
            false,
            function (array $competition) {
                $this->assertSame("grand_prix", $competition['type']);
            }
        ];

        yield "type not found" => [
            "type=foo",
            true
        ];

        yield "formation tat" => [
            "formation=tat",
            false,
            function (array $competition) {
                $this->assertSame("tat", $competition['formation']);
            }
        ];

        yield "formation dou" => [
            "formation=dou",
            false,
            function (array $competition) {
                $this->assertSame("dou", $competition['formation']);
            }
        ];

        yield "formation not found" => [
            "formation=bar",
            true
        ];

        yield "club df9fcbae-c6ff-11e8-a8d5-f2801f1b9fd1" => [
            "club.id=df9fcbae-c6ff-11e8-a8d5-f2801f1b9fd1",
            false,
            function (array $competition) {
                $this->assertSame("df9fcbae-c6ff-11e8-a8d5-f2801f1b9fd1", $competition['club']['id']);
            }
        ];

        yield "club a2782b47-3147-445d-9341-a2548a0c3e33" => [
            "club.id=a2782b47-3147-445d-9341-a2548a0c3e33",
            false,
            function (array $competition) {
                $this->assertSame("a2782b47-3147-445d-9341-a2548a0c3e33", $competition['club']['id']);
            }
        ];

        yield "club not found" => [
            "club.id=2029af32-c22d-4af3-b426-3ed20e22db8d",
            true
        ];

        yield "quotation pro" => [
            "quotation=pro",
            false,
            function (array $competition) {
                $this->assertSame("pro", $competition["quotation"]);
            }
        ];

        yield "quotation tc" => [
            "quotation=tc",
            false,
            function (array $competition) {
                $this->assertSame("tc", $competition["quotation"]);
            }
        ];

        yield "quotation not found" => [
            "quotation=foobar",
            true
        ];
    }
}
