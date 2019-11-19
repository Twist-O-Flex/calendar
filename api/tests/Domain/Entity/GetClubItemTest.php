<?php

namespace App\Tests\Domain\Entity;

use App\Tests\ApiTestCase;

class GetClubItemTest extends ApiTestCase
{
    public function testSchema(): void
    {
        $response = static::createClient()->request('GET', '/clubs/e72a6b32-6066-5900-8dfa-aaa30a3553ae');

        $this->assertResponseIsSuccessful();
        $this->assertJson($response->getContent());

        $this->assertSame(
            [
                '@context' => '/contexts/Club',
                '@id' => '/clubs/e72a6b32-6066-5900-8dfa-aaa30a3553ae',
                '@type' => 'Club',
                'id' => 'e72a6b32-6066-5900-8dfa-aaa30a3553ae',
                'name' => 'Boule luisante',
                'address' => [
                    'city' => [
                        'name' => 'Sartrouville',
                        'zipCode' => '78500',
                    ],
                    'street' => '4 rue de la pouille',
                ],
                'contact' => [
                    'emails' => [
                        'toto@example.com',
                        'tutu@example.com',
                    ],
                    'phoneNumbers' => [
                        '+9855562307762',
                    ],
                ],
            ],
            \Safe\json_decode($response->getContent(), true)
        );
    }
}
