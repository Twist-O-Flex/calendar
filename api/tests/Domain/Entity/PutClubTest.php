<?php

namespace App\Tests\Domain\Entity;

use App\Tests\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class PutClubTest extends ApiTestCase
{
    public function testPut(): void
    {
        $response = $this->getAuthenticatedClientWith('021c6dc9-4a8e-416a-96ca-b73fed2adb35')->request(
            'PUT',
            '/clubs/df9fcbae-c6ff-11e8-a8d5-f2801f1b9fd1',
            [
                'json' => $this->getValidPayload(),
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
                'city' => 'Pamiers',
                'zipCode' => '09100',
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

        $assert(\Safe\json_decode($response->getContent(false), true)['violations']);
    }

    public function invalidPayloadProvider(): \Generator
    {
        yield [
            'df9fcbae-c6ff-11e8-a8d5-f2801f1b9fd1',
            [
                'name' => 'toto',
                'address' => [],
                'contact' => [],
            ],
            function (array $violations) {
                $this->assertSame(
                    [
                        [
                            "propertyPath" => "address.city",
                            "message" => "This value should not be blank.",
                        ],
                        [
                            "propertyPath" => "address.zipCode",
                            "message" => "This value should not be blank.",
                        ],
                        [
                            "propertyPath" => "address.street",
                            "message" => "This value should not be blank.",
                        ],
                        [
                            "propertyPath" => "contact.emails",
                            "message" => "This value should not be blank.",
                        ],
                        [
                            "propertyPath" => "contact.phoneNumbers",
                            "message" => "This value should not be blank.",
                        ],
                    ],
                    $violations
                );
            }
        ];


        yield [
            'df9fcbae-c6ff-11e8-a8d5-f2801f1b9fd1',
            [
                'name' => 'tata',
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
                        [
                            'propertyPath' => 'contact.emails[0]',
                            'message' => 'This value is not a valid email address.',
                        ],
                        [
                            'propertyPath' => 'contact.phoneNumbers[1]',
                            'message' => 'This is not a valid phone number.',
                        ],
                    ],
                    $violations
                );
            }
        ];
    }

    public function testPutReturnUnauthorized(): void
    {
        $response = $this->getAnonymousClient()->request(
            'PUT',
            '/clubs/df9fcbae-c6ff-11e8-a8d5-f2801f1b9fd1',
            ['json' => $this->getValidPayload()]
        );

        $this->assertSame(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    public function testPutReturnForbidden(): void
    {
        $response = $this->getAuthenticatedClientWith('c1b618cf-e3c0-4119-a6ee-ef1c0d325bc3')->request(
            'PUT',
            '/clubs/df9fcbae-c6ff-11e8-a8d5-f2801f1b9fd1',
            ['json' => $this->getValidPayload()]
        );

        $this->assertSame(Response::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    public function testPutReturnNotFound(): void
    {
        $response = $this->getAuthenticatedClientWith('021c6dc9-4a8e-416a-96ca-b73fed2adb35')->request(
            'PUT',
            '/clubs/6001a54e-e73a-4952-97c5-4351b7262cf8',
            [
                'json' => $this->getValidPayload(),
            ]
        );

        $this->assertSame(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    private function getValidPayload(): array
    {
        return [
            'name' => 'La Boule Qui Roule',
            'address' => [
                'city' => 'Pamiers',
                'zipCode' => '09100',
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
        ];
    }
}
