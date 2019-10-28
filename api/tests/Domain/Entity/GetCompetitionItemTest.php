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
                    "@id" => "/clubs/0b17ca3e-490b-3ddb-aa78-35b4ce668dc0",
                    "@type" => "Club",
                    "id" => "0b17ca3e-490b-3ddb-aa78-35b4ce668dc0",
                    "address" => [
                    "city" => "Nikkishire",
                    "zipCode" => "33282",
                    "street" => "4545 Streich Views Suite 225",
                    ],
                    "contact" => [
                    "emails" => [
                    0 => "morissette.erna@example.org",
                    ],
                    "phoneNumbers" =>  [
                    0 => "+4466675661846",
                    1 => "+2320272534524",
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
