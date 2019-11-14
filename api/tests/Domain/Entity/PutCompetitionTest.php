<?php

namespace App\Tests\Domain\Entity;

use App\Tests\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class PutCompetitionTest extends ApiTestCase
{
    /**
     * @dataProvider validPayloadProvider
     */
    public function testPut(array $payload): void
    {
        $response = $this->getAuthenticatedClientWith('021c6dc9-4a8e-416a-96ca-b73fed2adb35')->request(
            'PUT',
            '/competitions/7d853409-ff26-4097-826e-e1f78f5a5a01',
            ['json' => $payload]
        );

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertJson($content = $response->getContent());
        $content = \Safe\json_decode($content, true);

        $this->assertArrayHasKey('@context', $content);
        $this->assertArrayHasKey('@id', $content);
        $this->assertArrayHasKey('@type', $content);
        $this->assertArrayHasKey('id', $content);
        $this->assertSame('national', $content['category']);
        $this->assertSame('dou', $content['formation']);
        $this->assertSame('/clubs/df9fcbae-c6ff-11e8-a8d5-f2801f1b9fd1', $content['club']);
        $this->assertEquals(
            new \DateTimeImmutable('2019-11-09T17:08:51+01:00'),
            new \DateTimeImmutable($content['startDate'])
        );
        $this->assertSame(5, $content['duration']);
        $this->assertSame('pro', $content['quotation']);
    }

    public function validPayloadProvider(): \Generator
    {
        yield [
            [
                'category' => 'national',
                'formation' => 'dou',
                'club' => ['id' => 'df9fcbae-c6ff-11e8-a8d5-f2801f1b9fd1'],
                'startDate' => '2019-11-09T17:08:51+01:00',
                'duration' => 5,
                'quotation' => 'pro',
            ],
        ];
    }

    /**
     * @dataProvider invalidPayloadProvider
     */
    public function testPutCompetitionWithInvalidPayload(string $competitionId, array $payload, callable $assert): void
    {
        $response = $this->getAuthenticatedClientWith('021c6dc9-4a8e-416a-96ca-b73fed2adb35')->request(
            'PUT',
            "/competitions/$competitionId",
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
            '7d853409-ff26-4097-826e-e1f78f5a5a01',
            [
                [],
            ],
            function (array $violations) {
                $this->assertSame(
                    [
                        "category" => ["This value should not be blank."],
                        "formation" => ["This value should not be blank."],
                        "club" => ["This value should not be blank."],
                        "startDate" => ["This value should not be blank."],
                        "duration" => ["This value should not be blank."],
                        "quotation" => ["This value should not be blank."],
                    ],
                    $violations
                );
            }
        ];

        yield [
            '7d853409-ff26-4097-826e-e1f78f5a5a01',
            [
                [
                    'category' => '',
                    'formation' => '',
                    'club' => '',
                    'startDate' => '',
                    'duration' => '',
                    'quotation' => '',
                ],
            ],
            function (array $violations) {
                $this->assertSame(
                    [
                        "category" => ["This value should not be blank."],
                        "formation" => ["This value should not be blank."],
                        "club" => ["This value should not be blank."],
                        "startDate" => ["This value should not be blank."],
                        "duration" => ["This value should not be blank."],
                        "quotation" => ["This value should not be blank."],
                    ],
                    $violations
                );
            }
        ];

        yield [
            '7d853409-ff26-4097-826e-e1f78f5a5a01',
            [
                'category' => 'foo',
                'formation' => 'bar',
                'club' => ['id' => '0008964b-81e0-4cb6-a404-62081a76cea1'],
                'startDate' => '2019-11-06',
                'duration' => 0,
                'quotation' => 'foobar',
            ],
            function (array $violations) {
                $this->assertSame(
                    [
                        "category" => ["The value you selected is not a valid choice."],
                        "formation" => ["The value you selected is not a valid choice."],
                        "club.id" => ["The club with id: 0008964b-81e0-4cb6-a404-62081a76cea1 doesn't exist."],
                        "startDate" => ["This value is not a valid datetime."],
                        "duration" => ["This value should be greater than or equal to 1."],
                        "quotation" => ["The value you selected is not a valid choice."],
                    ],
                    $violations
                );
            }
        ];

        yield [
            '7d853409-ff26-4097-826e-e1f78f5a5a01',
            [
                'category' => 'championship',
                'formation' => 'tri',
                'club' => ['id' => 'df9fcbae-c6ff-11e8-a8d5-f2801f1b9fd1'],
                'startDate' => '2019-11-06T15:08:51+01:00',
                'duration' => '2',
                'quotation' => 'tc',
            ],
            function (array $violations) {
                $this->assertSame(["duration" => ["This value should be of type integer."]], $violations);
            }
        ];
    }

    /**
     * @dataProvider validPayloadProvider
     */
    public function testPutCompetitionReturnUnauthorized(array $payload): void
    {
        $this->getAnonymousClient()->request(
            'PUT',
            '/competitions/7d853409-ff26-4097-826e-e1f78f5a5a01',
            ['json' => $payload]
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @dataProvider validPayloadProvider
     */
    public function testPutCompetitionReturnForbidden(array $payload): void
    {
        $this->getAuthenticatedClientWith('c1b618cf-e3c0-4119-a6ee-ef1c0d325bc3')->request(
            'PUT',
            '/competitions/7d853409-ff26-4097-826e-e1f78f5a5a01',
            ['json' => $payload]
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @dataProvider validPayloadProvider
     */
    public function testPutCompetitionReturnNotFound(array $payload): void
    {
        $this->getAuthenticatedClientWith('021c6dc9-4a8e-416a-96ca-b73fed2adb35')->request(
            'PUT',
            '/competitions/4153e5bf-cba7-4d55-81ff-9983d7323c52',
            ['json' => $payload]
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }
}
