<?php

namespace App\Tests\Domain\Entity;

use App\Tests\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class PostClubTest extends ApiTestCase
{
    /**
     * @dataProvider validPayloadProvider
     */
    public function testPostClub(array $payload): void
    {
        $response = $this->getAuthenticatedClientWith('021c6dc9-4a8e-416a-96ca-b73fed2adb35')->request(
            'POST',
            '/clubs',
            ['json' => $payload]
        );

        $this->assertSame(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertJson($content = $response->getContent());
        $content = \Safe\json_decode($content, true);

        $this->assertArrayHasKey('@context', $content);
        $this->assertArrayHasKey('@id', $content);
        $this->assertArrayHasKey('@type', $content);
        $this->assertSame('La Boule A Zéro', $content['name']);
        $this->assertSame(
            [
                'city' => 'Sartrouville',
                'zipCode' => '78500',
                'street' => '6 rue Lisse',
            ],
            $content['address']
        );
        $this->assertSame(
            [
                'emails' => ['labouleazero@gmail.com'],
                'phoneNumbers' => ['0123456789'],
            ],
            $content['contact']
        );
    }

    /**
     * @dataProvider invalidPayloadProvider
     */
    public function testPostClubWithInvalidPayload(array $payload, callable $assert): void
    {
        $response = $this->getAuthenticatedClientWith('021c6dc9-4a8e-416a-96ca-b73fed2adb35')->request(
            'POST',
            '/clubs',
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
        yield [
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
            [
                'name' => null,
                'address' => [],
                'contact' => [],
            ],
            function (array $violations) {
                $this->assertSame(
                    [
                        "name" => ["This value should not be blank."],
                        "address.city" => ["This value should not be blank."],
                        "address.zipCode" => ["This value should not be blank."],
                        "address.street" => ["This value should not be blank."],
                        "contact.emails" => ["This value should not be blank."],
                        "contact.phoneNumbers" => ["This value should not be blank."],
                    ],
                    $violations
                );
            }
        ];

        yield [
            [
                'name' => 123456,
                'address' => [
                    'city' => 'Sartrouville',
                    'zipCode' => '78500',
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
                        'contact.emails[0]' => ['This value is not a valid email address.'],
                        'contact.phoneNumbers[1]' => ['This is not a valid phone number.'],
                    ],
                    $violations
                );
            }
        ];
    }

    /**
     * @dataProvider validPayloadProvider
     */
    public function testPostClubReturnUnauthorized(array $payload): void
    {
        $response = $this->getAnonymousClient()->request(
            'POST',
            '/clubs',
            ['json' => $payload]
        );

        $this->assertSame(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    /**
     * @dataProvider validPayloadProvider
     */
    public function testPostClubReturnForbidden(array $payload): void
    {
        $response = $this->getAuthenticatedClientWith('c1b618cf-e3c0-4119-a6ee-ef1c0d325bc3')->request(
            'POST',
            '/clubs',
            ['json' => $payload]
        );

        $this->assertSame(Response::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    public function validPayloadProvider(): \Generator
    {
        yield [
            [
                'name' => 'La Boule A Zéro',
                'address' => [
                    'city' => 'Sartrouville',
                    'zipCode' => '78500',
                    'street' => '6 rue Lisse',
                ],
                'contact' => [
                    'emails' => ['labouleazero@gmail.com'],
                    'phoneNumbers' => ['0123456789'],
                ],
            ]
        ];
    }
}
