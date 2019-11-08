<?php

namespace App\Domain\DTO;

use App\Domain\Validation\Constraint\ClubExists;
use App\Domain\Validation\ValidationGroups;
use Symfony\Component\Validator\Constraints as Assert;

final class ClubInput
{
    /**
     * @Assert\NotNull(groups=ValidationGroups::COMPETITION_WRITE)
     * @Assert\NotBlank(groups=ValidationGroups::COMPETITION_WRITE)
     * @Assert\Uuid(groups=ValidationGroups::COMPETITION_WRITE)
     * @ClubExists(groups=ValidationGroups::COMPETITION_WRITE)
     */
    public $id;

    /**
     * @Assert\Type("string")
     * @Assert\NotBlank(groups=ValidationGroups::CLUB_WRITE)
     */
    public $name;

    /**
     * @var AddressInput
     *
     * @Assert\NotNull(groups=ValidationGroups::CLUB_WRITE)
     * @Assert\Valid
     */
    public $address;

    /**
     * @var ContactInput
     *
     * @Assert\NotNull(groups=ValidationGroups::CLUB_WRITE)
     * @Assert\Valid
     */
    public $contact;
}
