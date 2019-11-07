<?php

namespace App\Domain\Validation\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ClubExists extends Constraint
{
    public $message = "The club with id: {{ id }} doesn't exist";
}
