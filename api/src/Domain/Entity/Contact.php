<?php

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Serialization\SerializationGroups;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Embeddable
 */
class Contact
{
    /**
     * @ORM\Column(type="json_document", options={"jsonb": true})
     *
     * @Groups(SerializationGroups::READ)
     *
     * @Assert\NotBlank
     * @Assert\All({
     *      @Assert\Email
     * })
     */
    private $emails;

    /**
     * @ORM\Column(type="json_document", options={"jsonb": true})
     *
     * @Groups(SerializationGroups::READ)
     *
     * @Assert\NotBlank
     * @Assert\All({
     *      @Assert\Regex(pattern="#^(?:\+33|0)[0-9]{9}$#", message="This is not a valid phone number.")
     * })
     */
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
