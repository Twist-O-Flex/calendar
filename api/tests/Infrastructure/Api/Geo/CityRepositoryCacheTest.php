<?php

namespace App\Tests\Infrastructure\Api\Geo;

use App\Domain\Repository\CityRepositoryInterface;
use App\Infrastructure\Api\Geo\City;
use App\Infrastructure\Api\Geo\CityRepositoryCache;
use App\Tests\ApiTestCase;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Psr\Cache\CacheItemPoolInterface;

class CityRepositoryCacheTest extends ApiTestCase
{
    public function testGetCityByNameAndZipCodeShouldCallDecorated(): void
    {
        $expectedCity = new City("Sartrouville", "78500");

        /** @var CacheItemPoolInterface $cache */
        $cache = $this->get("test." . CacheItemPoolInterface::class);
        $cache->deleteItem(sha1("api:geo:city:Sartrouville:78500"));

        $decoratedStub = $this->prophesize(CityRepositoryInterface::class);
        $decoratedStub
            ->getCityByNameAndZipCode(Argument::type("string"), Argument::type("string"))
            ->willReturn($expectedCity);

        $cityRepository = new CityRepositoryCache($decoratedStub->reveal(), $cache);
        $this->assertEquals($expectedCity, $cityRepository->getCityByNameAndZipCode("Sartrouville", "78500"));

        $this->assertTrue($cache->getItem(sha1("api:geo:city:Sartrouville:78500"))->isHit());
    }

    public function testGetCityByNameAndZipCodeShouldNotCallDecorated(): void
    {
        $expectedCity = new City("Sartrouville", "78500");

        /** @var CacheItemPoolInterface $cache */
        $cache = $this->get("test." . CacheItemPoolInterface::class);
        $cache->deleteItem(sha1("api:geo:city:Sartrouville:78500"));
        $item = $cache->getItem(sha1("api:geo:city:Sartrouville:78500"));
        $item->set($expectedCity);
        $cache->save($item);

        $decoratedStub = $this->prophesize(CityRepositoryInterface::class);
        $decoratedStub
            ->getCityByNameAndZipCode(Argument::type("string"), Argument::type("string"))
            ->shouldNotBeCalled();

        $cityRepository = new CityRepositoryCache($decoratedStub->reveal(), $cache);
        $this->assertEquals($expectedCity, $cityRepository->getCityByNameAndZipCode("Sartrouville", "78500"));

        $this->assertTrue($cache->getItem(sha1("api:geo:city:Sartrouville:78500"))->isHit());
    }
}
