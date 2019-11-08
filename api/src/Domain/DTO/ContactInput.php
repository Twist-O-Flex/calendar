<?php

namespace App\Domain\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class ContactInput
{
    /**
     * @Assert\NotBlank
     * @Assert\All({
     *     @Assert\Email
     * })
     */
    public $emails;

    /**
     * @Assert\NotBlank
     * @Assert\All({
     *     @Assert\Regex(pattern="#^(?:\+33|0)[0-9]{9}$#", message="This is not a valid phone number.")
     * })
     */
    public $phoneNumbers;
}
