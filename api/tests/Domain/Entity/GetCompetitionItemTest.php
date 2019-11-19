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
        $this->assertSame(
            [
                "@context" => "/contexts/Competition",
                "@id" => "/competitions/7d853409-ff26-4097-826e-e1f78f5a5a01",
                "@type" => "Competition",
                "id" => "7d853409-ff26-4097-826e-e1f78f5a5a01",
                "type" => "national",
                "formation" => "tri",
                "club" => [
                    "@id" => "/clubs/e72a6b32-6066-5900-8dfa-aaa30a3553ae",
                    "@type" => "Club",
                    "id" => "e72a6b32-6066-5900-8dfa-aaa30a3553ae",
                    "name" => "Boule luisante",
                    "address" => [
                        "city" => [
                            "name" => "Sartrouville",
                            "zipCode" => "78500",
                        ],
                        "street" => "4 rue de la pouille",
                    ],
                    "contact" => [
                        "emails" => [
                            "toto@example.com",
                            "tutu@example.com"
                        ],
                        "phoneNumbers" =>  [
                            '+9855562307762'
                        ],
                    ],
                ],
                "startDate" => "2019-10-05T00:00:00+00:00",
                "duration" => 1,
                "quotation" => "tc",
            ],
            \Safe\json_decode($response->getContent(), true)
        );
    }
}
