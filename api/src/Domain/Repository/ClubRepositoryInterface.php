<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Club;

interface ClubRepositoryInterface
{
    public function find(string $id): ?Club;
}
