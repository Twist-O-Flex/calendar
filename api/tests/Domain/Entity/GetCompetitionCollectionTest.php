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

            $this->assertArrayHasKey("city", $competition['club']['address']);
            $this->assertCount(1, $competition['club']['address']);

            $this->assertArrayHasKey("name", $competition['club']['address']['city']);
            $this->assertArrayHasKey("zipCode", $competition['club']['address']['city']);
            $this->assertCount(2, $competition['club']['address']['city']);

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

        yield "club e72a6b32-6066-5900-8dfa-aaa30a3553ae" => [
            "club.id=e72a6b32-6066-5900-8dfa-aaa30a3553ae",
            false,
            function (array $competition) {
                $this->assertSame("e72a6b32-6066-5900-8dfa-aaa30a3553ae", $competition['club']['id']);
            }
        ];

        yield "club a070794d-5698-55bb-997e-b52a169668e5" => [
            "club.id=a070794d-5698-55bb-997e-b52a169668e5",
            false,
            function (array $competition) {
                $this->assertSame("a070794d-5698-55bb-997e-b52a169668e5", $competition['club']['id']);
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

        yield 'club name not matching case' => [
            'club.name=boule',
            false,
            function (array $competition) {
                $this->assertRegExp('#boule#i', $competition['club']['name']);
            }
        ];

        yield 'club name matching case' => [
            'club.name=Boule',
            false,
            function (array $competition) {
                $this->assertRegExp('#boule#i', $competition['club']['name']);
            }
        ];

        yield 'club name with words not matching case' => [
            'club.name=boule Dorée',
            false,
            function (array $competition) {
                $this->assertRegExp('#boule Dorée#i', $competition['club']['name']);
            }
        ];

        yield 'club name not found' => [
            'club.name=foo',
            true
        ];

        yield 'club city matching case' => [
            'club.address.city.name=Sartrou',
            false,
            function (array $competition) {
                $this->assertSame('Sartrouville', $competition['club']['address']['city']['name']);
            }
        ];

        yield 'city not matching case' => [
            'club.address.city.name=sartrouville',
            false,
            function (array $competition) {
                $this->assertSame('Sartrouville', $competition['club']['address']['city']['name']);
            }
        ];

        yield 'city not found' => [
            'club.address.city.name=paris',
            true
        ];

        yield 'Zip code' => [
            'club.address.city.zipCode=78500',
            false,
            function (array $competition) {
                $this->assertSame('78500', $competition['club']['address']['city']['zipCode']);
            }
        ];

        yield 'Zip code partial' => [
            'club.address.city.zipCode=78500',
            false,
            function (array $competition) {
                $this->assertRegExp('#^78#i', $competition['club']['address']['city']['zipCode']);
            }
        ];

        yield 'zip code not found' => [
            'club.address.city.zipCode=75',
            true
        ];
    }
}
