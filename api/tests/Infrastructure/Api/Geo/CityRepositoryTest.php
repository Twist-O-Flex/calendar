<?php

namespace App\Tests\Infrastructure\Api\Geo;

use App\Domain\Entity\CityInterface;
use App\Infrastructure\Api\Geo\City;
use App\Infrastructure\Api\Geo\CityRepository;
use App\Tests\ApiTestCase;

class CityRepositoryTest extends ApiTestCase
{
    /**
     * @dataProvider validZipCode
     */
    public function testGetCityDepartementCodeFromZipCode(string $name, string $zipCode, CityInterface $expected): void
    {
        $this->assertInstanceOf(
            CityInterface::class,
            $city = $this->get("test" . CityRepository::class)->getCityByNameAndZipCode($name, $zipCode)
        );

        $this->assertEquals($expected, $city);
    }

    public function validZipCode(): \Generator
    {
        yield ["Saint dié", "88100", new City("Saint-Dié-des-Vosges", "88100")];

        yield ["Sartrouville", "78500", new City("Sartrouville", "78500")];
    }

    public function testGetCityDepartementCodeReturnNull(): void
    {
        $this->assertNull($this->get("test" . CityRepository::class)->getCityByNameAndZipCode("foo", "154344"));
    }
}
