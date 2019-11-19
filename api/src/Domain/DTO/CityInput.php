<?php

namespace App\Domain\DTO;

use App\Domain\Validation\Constraint\CityExists;
use App\Domain\Validation\ValidationGroups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @CityExists(groups=ValidationGroups::CITY_CLASS)
 */
final class CityInput
{
    /**
     * @Assert\Type("string")
     * @Assert\NotBlank
     */
    public $name;

    /**
     * @Assert\Type("string")
     * @Assert\NotBlank
     */
    public $zipCode;
}
