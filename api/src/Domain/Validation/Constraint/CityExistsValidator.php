<?php

namespace App\Domain\Validation\Constraint;

use App\Domain\DTO\CityInput;
use App\Domain\Repository\CityRepositoryInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class CityExistsValidator extends ConstraintValidator
{
    private $cityRepository;

    public function __construct(CityRepositoryInterface $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    public function validate($cityInput, Constraint $constraint)
    {
        if (!$constraint instanceof CityExists) {
            throw new UnexpectedTypeException($constraint, CityExists::class);
        }

        if (!$cityInput instanceof CityInput) {
            throw new UnexpectedTypeException($cityInput, CityInput::class);
        }

        if (null === $this->cityRepository->getCityByNameAndZipCode($cityInput->name, $cityInput->zipCode)) {
            $this->context
                ->buildViolation($constraint->message)
                ->setParameters([
                    "{{ name }}" => $cityInput->name,
                    "{{ zipCode }}" => $cityInput->zipCode,
                ])
                ->addViolation();
        }
    }
}
