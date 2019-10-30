<?php

namespace App\Tests;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Contracts\HttpClient\ResponseStreamInterface;
use Webmozart\Assert\Assert;

class JwtClient implements HttpClientInterface
{
    private $decorated;
    private $jwt;

    public function __construct(HttpClientInterface $decorated, string $jwt)
    {
        $this->decorated = $decorated;
        $this->jwt = $jwt;
    }

    public function request(string $method, string $url, array $options = []): ResponseInterface
    {
        Assert::keyNotExists($options, 'auth_bearer');

        $options['auth_bearer'] = $this->jwt;

        return $this->decorated->request($method, $url, $options);
    }

    public function stream($responses, float $timeout = null): ResponseStreamInterface
    {
        return $this->decorated->stream($responses, $timeout);
    }
}
