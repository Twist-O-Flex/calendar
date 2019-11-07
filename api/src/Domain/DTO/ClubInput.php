<?php

namespace App\Domain\DTO;

use App\Domain\Entity\Address;
use App\Domain\Entity\Contact;
use Symfony\Component\Validator\Constraints as Assert;
use App\Domain\Validation\ValidationGroups;
use App\Domain\Validation\Constraint\ClubExists;

final class ClubInput
{
    /**
     * @var string
     *
     * @Assert\NotNull(groups=ValidationGroups::COMPETITION_WRITE)
     * @Assert\NotBlank(groups=ValidationGroups::COMPETITION_WRITE)
     * @Assert\Uuid(groups=ValidationGroups::COMPETITION_WRITE)
     * @ClubExists(groups=ValidationGroups::COMPETITION_WRITE)
     */
    public $id;

    /**
     * @var string
     *
     * @Assert\NotNull(groups=ValidationGroups::CLUB_WRITE)
     * @Assert\NotBlank(groups=ValidationGroups::CLUB_WRITE)
     */
    public $name;

    /**
     * @var Address
     *
     * @Assert\NotNull(groups=ValidationGroups::CLUB_WRITE)
     * @Assert\Valid
     */
    public $address;

    /**
     * @var Contact
     *
     * @Assert\NotNull(groups=ValidationGroups::CLUB_WRITE)
     * @Assert\Valid
     */
    public $contact;
}
