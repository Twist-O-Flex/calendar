<?php

namespace App\Tests\Domain\Entity;

use App\Tests\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class PutClubTest extends ApiTestCase
{
    /**
     * @dataProvider validPayloadProvider
     */
    public function testPutClub(array $payload): void
    {
        $response = $this->getAuthenticatedClientWith('021c6dc9-4a8e-416a-96ca-b73fed2adb35')->request(
            'PUT',
            '/clubs/e72a6b32-6066-5900-8dfa-aaa30a3553ae',
            [
                'json' => $payload,
            ]
        );

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertJson($content = $response->getContent());
        $content = \Safe\json_decode($content, true);

        $this->assertArrayHasKey('@context', $content);
        $this->assertArrayHasKey('@id', $content);
        $this->assertArrayHasKey('@type', $content);
        $this->assertSame('La Boule Qui Roule', $content['name']);
        $this->assertSame(
            [
                'city' => [
                    'name' => 'Pamiers',
                    'zipCode' => '09100',
                ],
                'street' => '4 rue penchée',
            ],
            $content['address']
        );
        $this->assertSame(
            [
                'emails' => [
                    'laboulequiroule@gmail.com',
                    'marcel.patoulachi@gmail.com',
                ],
                'phoneNumbers' => [
                    '0598764321',
                    '0512346789',
                ],
            ],
            $content['contact']
        );
    }

    /**
     * @dataProvider invalidPayloadProvider
     */
    public function testPutClubWithInvalidPayload(string $clubId, array $payload, callable $assert): void
    {
        $response = $this->getAuthenticatedClientWith('021c6dc9-4a8e-416a-96ca-b73fed2adb35')->request(
            'PUT',
            "/clubs/$clubId",
            [
                'json' => $payload,
            ]
        );

        $this->assertSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());

        $assert(
            $this->formatViolations(
                \Safe\json_decode($response->getContent(false), true)['violations']
            )
        );
    }

    public function invalidPayloadProvider(): \Generator
    {
        /*
         * Be aware validations are done sequentially
         */

        yield [
            'e72a6b32-6066-5900-8dfa-aaa30a3553ae',
            [],
            function (array $violations) {
                $this->assertSame(
                    [
                        "name" => ["This value should not be blank."],
                        "address" => ["This value should not be null."],
                        "contact" => ["This value should not be null."],
                    ],
                    $violations
                );
            }
        ];

        yield [
            'e72a6b32-6066-5900-8dfa-aaa30a3553ae',
            [
                'address' => [],
                'contact' => [],
            ],
            function (array $violations) {
                $this->assertSame(
                    [
                        "address.city" => ["This value should not be null."],
                        "address.street" => ["This value should not be blank."],
                        "contact.emails" => ["This value should not be blank."],
                        "contact.phoneNumbers" => ["This value should not be blank."],
                    ],
                    $violations
                );
            }
        ];

        yield [
            'e72a6b32-6066-5900-8dfa-aaa30a3553ae',
            \array_replace(\iterator_to_array($this->validPayloadProvider())[0][0], ["name" => null]),
            function (array $violations) {
                $this->assertSame(
                    [
                        "name" => ["This value should not be blank."],
                    ],
                    $violations
                );
            }
        ];

        yield [
            'e72a6b32-6066-5900-8dfa-aaa30a3553ae',
            [
                'name' => 123456,
                'address' => [
                    'city' => [
                        'name' => '',
                        'zipCode' => '',
                    ],
                    'street' => '6 rue Lisse',
                ],
                'contact' => [
                    'emails' => ['labouleazerogmail.com', 'toto@gmail.com'],
                    'phoneNumbers' => ['0123456789', '102115'],
                ],
            ],
            function (array $violations) {
                $this->assertSame(
                    [
                        'name' => ['This value should be of type string.'],
                        'address.city.name' => ['This value should not be blank.'],
                        'address.city.zipCode' => ['This value should not be blank.'],
                        'contact.emails[0]' => ['This value is not a valid email address.'],
                        'contact.phoneNumbers[1]' => ['This is not a valid phone number.'],
                    ],
                    $violations
                );
            }
        ];

        yield [
            'e72a6b32-6066-5900-8dfa-aaa30a3553ae',
            \array_replace(
                \iterator_to_array($this->validPayloadProvider())[0][0],
                [
                    'address' => [
                        'city' => [
                            'name' => 'bar',
                            'zipCode' => '78500',
                        ],
                        'street' => '6 rue Lisse',
                    ],
                ]
            ),
            function (array $violations) {
                $this->assertSame(
                    [
                        "address.city" => ["City not found from name: bar and zip code: 78500."],
                    ],
                    $violations
                );
            }
        ];
    }

    /**
     * @dataProvider validPayloadProvider
     */
    public function testPutClubReturnUnauthorized(array $payload): void
    {
        $this->getAnonymousClient()->request(
            'PUT',
            '/clubs/e72a6b32-6066-5900-8dfa-aaa30a3553ae',
            ['json' => $payload]
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @dataProvider validPayloadProvider
     */
    public function testPutClubReturnForbidden(array $payload): void
    {
        $this->getAuthenticatedClientWith('c1b618cf-e3c0-4119-a6ee-ef1c0d325bc3')->request(
            'PUT',
            '/clubs/e72a6b32-6066-5900-8dfa-aaa30a3553ae',
            ['json' => $payload]
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @dataProvider validPayloadProvider
     */
    public function testPutClubReturnNotFound(array $payload): void
    {
        $this->getAuthenticatedClientWith('021c6dc9-4a8e-416a-96ca-b73fed2adb35')->request(
            'PUT',
            '/clubs/6001a54e-e73a-4952-97c5-4351b7262cf8',
            ['json' => $payload]
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    public function validPayloadProvider(): \Generator
    {
        yield [
            [
                'name' => 'La Boule Qui Roule',
                'address' => [
                    'city' => [
                        'name' => 'Pamiers',
                        'zipCode' => '09100',
                    ],
                    'street' => '4 rue penchée',
                ],
                'contact' => [
                    'emails' => [
                        'laboulequiroule@gmail.com',
                        'marcel.patoulachi@gmail.com',
                    ],
                    'phoneNumbers' => [
                        '0598764321',
                        '0512346789',
                    ],
                ],
            ]
        ];

        yield [
            [
                'name' => 'La Boule Qui Roule',
                'address' => [
                    'city' => [
                        'name' => 'Pamier', // correct name should be retrieved
                        'zipCode' => '09100',
                    ],
                    'street' => '4 rue penchée',
                ],
                'contact' => [
                    'emails' => [
                        'laboulequiroule@gmail.com',
                        'marcel.patoulachi@gmail.com',
                    ],
                    'phoneNumbers' => [
                        '0598764321',
                        '0512346789',
                    ],
                ],
            ]
        ];
    }
}
