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
                    "@id" => "/clubs/df9fcbae-c6ff-11e8-a8d5-f2801f1b9fd1",
                    "@type" => "Club",
                    "id" => "df9fcbae-c6ff-11e8-a8d5-f2801f1b9fd1",
                    "name" => "Boule luisante",
                    "address" => [
                        "city" => "Sartrouville",
                        "zipCode" => "78500",
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
