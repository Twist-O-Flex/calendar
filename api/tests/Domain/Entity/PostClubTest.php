<?php

namespace App\Tests\Domain\Entity;

use App\Tests\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class PostClubTest extends ApiTestCase
{
    public function testPost(): void
    {
        $response = $this->getAuthenticatedClientWith('021c6dc9-4a8e-416a-96ca-b73fed2adb35')->request(
            'POST',
            '/clubs',
            ['json' => $this->getValidPayload()]
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

        $assert(\Safe\json_decode($response->getContent(false), true)['violations']);
    }

    public function invalidPayloadProvider(): \Generator
    {
        yield [
            [],
            function (array $violations) {
                $this->assertSame(
                    [
                        [
                            "propertyPath" => "name",
                            "message" => "This value should not be null.",
                        ],
                        [
                            "propertyPath" => "name",
                            "message" => "This value should not be blank.",
                        ],
                        [
                            "propertyPath" => "address",
                            "message" => "This value should not be null.",
                        ],
                        [
                            "propertyPath" => "contact",
                            "message" => "This value should not be null.",
                        ],
                    ],
                    $violations
                );
            }
        ];

        yield [
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

    public function testPostReturnUnauthorized(): void
    {
        $response = $this->getAnonymousClient()->request(
            'POST',
            '/clubs',
            ['json' => $this->getValidPayload()]
        );

        $this->assertSame(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    public function testPostReturnForbidden(): void
    {
        $response = $this->getAuthenticatedClientWith('c1b618cf-e3c0-4119-a6ee-ef1c0d325bc3')->request(
            'POST',
            '/clubs',
            ['json' => $this->getValidPayload()]
        );

        $this->assertSame(Response::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    private function getValidPayload(): array
    {
        return [
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
        ];
    }
}
