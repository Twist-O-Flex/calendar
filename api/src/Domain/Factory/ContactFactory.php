<?php

namespace App\Domain\Factory;

use App\Domain\DTO\ContactInput;
use App\Domain\Entity\Contact;

class ContactFactory
{
    public function fromContactInput(ContactInput $contactInput): Contact
    {
        return (new Contact())
            ->setEmails($contactInput->emails)
            ->setPhoneNumbers($contactInput->phoneNumbers);
    }
}
