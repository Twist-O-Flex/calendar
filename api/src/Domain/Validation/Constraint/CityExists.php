<?php

namespace App\Domain\Validation\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CityExists extends Constraint
{
    public $message = "City not found from name: {{ name }} and zip code: {{ zipCode }}.";

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
