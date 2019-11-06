<?php

namespace App\Tests\Domain\Entity;

use App\Tests\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class PostCompetitionTest extends ApiTestCase
{
    public function testPost(): void
    {
        $response = $this->getAuthenticatedClientWith('021c6dc9-4a8e-416a-96ca-b73fed2adb35')->request(
            'POST',
            '/competitions',
            ['json' => $this->getValidPayload()]
        );

        $this->assertSame(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertJson($content = $response->getContent());
        $content = \Safe\json_decode($content, true);

        $this->assertArrayHasKey('@context', $content);
        $this->assertArrayHasKey('@id', $content);
        $this->assertArrayHasKey('@type', $content);
        $this->assertArrayHasKey('id', $content);
        $this->assertSame('championship', $content['type']);
        $this->assertSame('tri', $content['formation']);
        $this->assertSame('/clubs/df9fcbae-c6ff-11e8-a8d5-f2801f1b9fd1', $content['club']);
        $this->assertEquals(
            new \DateTimeImmutable('2019-11-06T15:08:51+01:00'),
            new \DateTimeImmutable($content['startDate'])
        );
        $this->assertSame(2, $content['duration']);
        $this->assertSame('tc', $content['quotation']);
    }

    private function getValidPayload(): array
    {
        return [
            'type' => 'championship',
            'formation' => 'tri',
            'club' => '/clubs/df9fcbae-c6ff-11e8-a8d5-f2801f1b9fd1',
            'startDate' => '2019-11-06T15:08:51+01:00',
            'duration' => 2,
            'quotation' => 'tc'
        ];
    }
}
