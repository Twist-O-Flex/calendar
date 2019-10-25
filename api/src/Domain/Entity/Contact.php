<?php

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Serialization\SerializationGroups;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Embeddable
 */
class Contact
{
    /**
     * @ORM\Column(type="json_document", options={"jsonb": true})
     *
     * @Groups(SerializationGroups::READ)
     */
    private $emails;

    /**
     * @ORM\Column(type="json_document", options={"jsonb": true})
     *
     * @Groups(SerializationGroups::READ)
     */
    private $phoneNumbers;

    public function getEmails(): array
    {
        return $this->emails;
    }

    public function getPhoneNumbers(): array
    {
        return $this->phoneNumbers;
    }
}
