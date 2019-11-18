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
            $this->assertArrayHasKey("address", $club);
            $this->assertCount(5, $club);

            $this->assertArrayHasKey("city", $club['address']);
            $this->assertCount(1, $club['address']);

            $this->assertArrayHasKey("name", $club['address']['city']);
            $this->assertArrayHasKey("zipCode", $club['address']['city']);
            $this->assertCount(2, $club['address']['city']);
        }

        $this->assertCount(3, $content["hydra:member"]);
    }

    /**
     * @dataProvider filterNameProvider
     */
    public function testFilter(string $filter, bool $shouldBeEmpty, callable $assert = null): void
    {
        $response = $this
            ->getAnonymousClient()
            ->request('GET', "/clubs?itemsPerPage=5&$filter");

        $this->assertResponseIsSuccessful();
        $this->assertJson($response->getContent());

        $content = \Safe\json_decode($response->getContent(), true);

        if ($shouldBeEmpty) {
            $this->assertEmpty($content["hydra:member"]);

            return;
        }

        $this->assertNotEmpty($content["hydra:member"]);

        foreach ($content["hydra:member"] as $club) {
            $assert($club);
        }
    }

    public function filterNameProvider(): \Generator
    {
        yield 'Name not matching case' => [
            'name=boule',
            false,
            function (array $club) {
                $this->assertRegExp('#boule#i', $club['name']);
            }
        ];

        yield 'Name matching case' => [
            'name=Boule',
            false,
            function (array $club) {
                $this->assertRegExp('#boule#i', $club['name']);
            }
        ];

        yield 'Name with words not matching case' => [
            'name=boule Dorée',
            false,
            function (array $club) {
                $this->assertRegExp('#boule Dorée#i', $club['name']);
            }
        ];

        yield 'Name not found' => [
            'name=foo',
            true
        ];

        yield 'city matching case' => [
            'address.city.name=Sartrou',
            false,
            function (array $club) {
                $this->assertSame('Sartrouville', $club['address']['city']['name']);
            }
        ];

        yield 'city not matching case' => [
            'address.city.name=sartrouville',
            false,
            function (array $club) {
                $this->assertSame('Sartrouville', $club['address']['city']['name']);
            }
        ];

        yield 'city not found' => [
            'address.city.name=paris',
            true
        ];

        yield 'Zip code' => [
            'address.city.zipCode=78500',
            false,
            function (array $club) {
                $this->assertSame('78500', $club['address']['city']['zipCode']);
            }
        ];

        yield 'Zip code partial' => [
            'address.city.zipCode=78500',
            false,
            function (array $club) {
                $this->assertRegExp('#^78#i', $club['address']['city']['zipCode']);
            }
        ];

        yield 'zip code not found' => [
            'address.city.zipCode=75',
            true
        ];
    }
}
