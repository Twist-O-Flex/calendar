<?php

namespace App\Domain\DTO;

use Symfony\Component\Validator\Constraints as Assert;

final class AddressInput
{
    /**
     * @Assert\Type("string")
     * @Assert\NotBlank
     */
    public $city;

    /**
     * @Assert\Type("string")
     * @Assert\NotBlank
     */
    public $zipCode;

    /**
     * @Assert\Type("string")
     * @Assert\NotBlank
     */
    public $street;
}
