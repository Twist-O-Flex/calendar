<?php

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class Contact
{
    /** @ORM\Column(type="json_document", options={"jsonb": true}) */
    private $emails;

    /** @ORM\Column(type="json_document", options={"jsonb": true}) */
    private $phoneNumbers;

    public function getEmails(): array
    {
        return $this->emails;
    }

    public function setEmails(array $emails): self
    {
        $this->emails = $emails;

        return $this;
    }

    public function getPhoneNumbers(): array
    {
        return $this->phoneNumbers;
    }

    public function setPhoneNumbers(array $phoneNumbers): self
    {
        $this->phoneNumbers = $phoneNumbers;

        return $this;
    }
}
