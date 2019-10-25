<?php

namespace App\Tests\Domain\Entity;

use App\Tests\ApiTestCase;

class GetClubItemTest extends ApiTestCase
{
    public function testSchema(): void
    {
        $response = static::createClient()->request('GET', '/clubs/df9fcbae-c6ff-11e8-a8d5-f2801f1b9fd1');

        $this->assertResponseIsSuccessful();
        $this->assertJson($response->getContent());

        $this->assertSame(
            [
                '@context' => '/contexts/Club',
                '@id' => '/clubs/df9fcbae-c6ff-11e8-a8d5-f2801f1b9fd1',
                '@type' => 'Club',
                'id' => 'df9fcbae-c6ff-11e8-a8d5-f2801f1b9fd1',
                'name' => 'Kaboum',
                'address' => [
                    'city' => 'Sartrouville',
                    'zipCode' => '78500',
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
