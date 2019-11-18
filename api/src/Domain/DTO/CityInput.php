<?php

namespace App\Domain\DTO;

use Symfony\Component\Validator\Constraints as Assert;

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
