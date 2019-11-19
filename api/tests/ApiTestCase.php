<?php

namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test;
use App\Infrastructure\Repository\UserRepository;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiTestCase extends Test\ApiTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        self::bootKernel();
    }

    public function get(string $service)
    {
        return self::$kernel->getContainer()->get($service);
    }

    public function getAnonymousClient(): HttpClientInterface
    {
        return self::createClient();
    }

    public function getAuthenticatedClientWith(string $userUuid): HttpClientInterface
    {
        $this->assertNotNull($user = $this->get("test." . UserRepository::class)->find($userUuid));

        return new JwtClient(self::createClient(), $this->get("lexik_jwt_authentication.jwt_manager")->create($user));
    }

    public function formatViolations(array $violations): array
    {
        $formatted = [];

        foreach ($violations as $violation) {
            $formatted[$violation['propertyPath']][] = $violation['message'];
        }

        return $formatted;
    }
}
