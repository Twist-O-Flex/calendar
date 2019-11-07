<?php

namespace App\Domain\DTO;

use Symfony\Component\Validator\Constraints as Assert;
use App\Domain\Entity\Competition;

final class CompetitionInput
{
    /**
     * @Assert\NotBlank
     * @Assert\Choice(Competition::ALL_TYPES)
     */
    public $type;

    /**
     * @Assert\NotBlank
     * @Assert\Choice(Competition::ALL_FORMATIONS)
     */
    public $formation;

    /**
     * @var ClubInput
     *
     * @Assert\NotBlank
     * @Assert\Valid
     */
    public $club;

    /**
     * @Assert\NotBlank
     * @Assert\DateTime(DATE_ATOM)
     */
    public $startDate;

    /**
     * @Assert\NotBlank
     * @Assert\Type("integer")
     * @Assert\GreaterThanOrEqual(Competition::MIN_DURATION)
     */
    public $duration;

    /**
     * @Assert\NotBlank
     * @Assert\Choice(Competition::ALL_QUOTATIONS)
     */
    public $quotation;
}
