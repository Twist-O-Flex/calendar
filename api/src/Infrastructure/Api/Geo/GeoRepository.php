<?php

namespace App\Infrastructure\Api\Geo;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class GeoRepository
{
    protected $httpClient;
    protected $uri = "https://geo.api.gouv.fr";

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }
}
