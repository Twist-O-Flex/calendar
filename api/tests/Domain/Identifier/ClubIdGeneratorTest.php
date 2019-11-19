<?php

namespace App\Tests\Domain\Identifier;

use App\Domain\DTO\AddressInput;
use App\Domain\DTO\CityInput;
use App\Domain\DTO\ClubInput;
use App\Domain\Identifier\ClubIdGenerator;
use App\Tests\ApiTestCase;

class ClubIdGeneratorTest extends ApiTestCase
{
    /**
     * @dataProvider clubInputProvider
     */
    public function testFromCityInput(ClubInput $clubInput, string $expected): void
    {
        $this->assertSame(
            $expected,
            $this->get("test." . ClubIdGenerator::class)->fromClubInput($clubInput)->toString()
        );
    }

    public function clubInputProvider(): \Generator
    {
        yield [
            $this->getClubInput(
                [
                    "name" => "Boule luisante",
                    "street" => "4 rue de la pouille",
                    "city" => [
                        "name" => "Sartrouville",
                        "zipCode" => "78500"
                    ],
                ]
            ),
            "e72a6b32-6066-5900-8dfa-aaa30a3553ae"
        ];

        yield [
            $this->getClubInput(
                [
                    "name" => "La Boule Dorée",
                    "street" => "1 rue du Cheval",
                    "city" => [
                        "name" => "Maison-Laffitte",
                        "zipCode" => "78600"
                    ],
                ]
            ),
            "a070794d-5698-55bb-997e-b52a169668e5"
        ];
    }

    private function getClubInput(array $data): ClubInput
    {
        $clubInput = new ClubInput();
        $clubInput->name = $data["name"];

        $addressInput = new AddressInput();
        $addressInput->street = $data["street"];

        $cityInput = new CityInput();
        $cityInput->name = $data["city"]["name"];
        $cityInput->zipCode = $data["city"]["zipCode"];

        $addressInput->city = $cityInput;
        $clubInput->address = $addressInput;

        return $clubInput;
    }
}
