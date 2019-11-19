<?php

namespace App\Domain\Validation\Constraint;

use App\Domain\Repository\ClubRepositoryInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class ClubExistsValidator extends ConstraintValidator
{
    private $clubRepository;

    public function __construct(ClubRepositoryInterface $clubRepository)
    {
        $this->clubRepository = $clubRepository;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof ClubExists) {
            throw new UnexpectedTypeException($constraint, ClubExists::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (null === $this->clubRepository->find($value)) {
            $this->context
                ->buildViolation($constraint->message)
                ->setParameter('{{ id }}', $value)
                ->addViolation();
        }
    }
}
