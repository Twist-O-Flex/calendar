<?php

namespace App\Infrastructure\Api\Geo;

use App\Domain\Entity\CityInterface;
use App\Domain\Repository\CityRepositoryInterface;
use Psr\Cache\CacheItemPoolInterface;

class CityRepositoryCache implements CityRepositoryInterface
{
    private $decorated;
    private $cache;

    public function __construct(CityRepositoryInterface $decorated, CacheItemPoolInterface $cache)
    {
        $this->decorated = $decorated;
        $this->cache = $cache;
    }

    public function getCityByNameAndZipCode(string $name, string $zipCode): ?CityInterface
    {
        $item = $this->cache->getItem(sha1("api:geo:city:$name:$zipCode"));

        if (!$item->isHit()) {
            $item->set($this->decorated->getCityByNameAndZipCode($name, $zipCode));
            $this->cache->save($item);
        }

        return $item->get();
    }
}
