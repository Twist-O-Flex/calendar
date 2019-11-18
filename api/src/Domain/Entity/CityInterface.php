<?php

namespace App\Domain\Entity;

interface CityInterface
{
    public function getName(): string;

    public function getZipCode(): string;
}
