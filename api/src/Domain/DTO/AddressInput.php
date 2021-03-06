<?php

namespace App\Domain\DTO;

use Symfony\Component\Validator\Constraints as Assert;

final class AddressInput
{
    /**
     * @var CityInput
     *
     * @Assert\NotNull
     * @Assert\Valid
     */
    public $city;

    /**
     * @Assert\Type("string")
     * @Assert\NotBlank
     */
    public $street;
}
