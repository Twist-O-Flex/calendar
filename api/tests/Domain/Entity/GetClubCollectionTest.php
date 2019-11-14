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
            $this->assertArrayHasKey("zipCode", $club['address']);
            $this->assertCount(2, $club['address']);
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
            'address.city=Sartrou',
            false,
            function (array $club) {
                $this->assertSame('Sartrouville', $club['address']['city']);
            }
        ];

        yield 'city not matching case' => [
            'address.city=sartrouville',
            false,
            function (array $club) {
                $this->assertSame('Sartrouville', $club['address']['city']);
            }
        ];

        yield 'city not found' => [
            'address.city=paris',
            true
        ];

        yield 'Zip code' => [
            'address.zipCode=78500',
            false,
            function (array $club) {
                $this->assertSame('78500', $club['address']['zipCode']);
            }
        ];

        yield 'Zip code partial' => [
            'address.zipCode=78500',
            false,
            function (array $club) {
                $this->assertRegExp('#^78#i', $club['address']['zipCode']);
            }
        ];

        yield 'zip code not found' => [
            'address.zipCode=75',
            true
        ];
    }
}
