<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Club;
use App\Domain\Repository\ClubRepositoryInterface;
use Webmozart\Assert\Assert;

class ClubRepositoryAdapter implements ClubRepositoryInterface
{
    private $clubRepository;

    public function __construct(ClubRepository $clubRepository)
    {
        $this->clubRepository = $clubRepository;
    }

    public function find(string $id): ?Club
    {
        Assert::nullOrIsInstanceOf($object = $this->clubRepository->find($id), Club::class);

        /** @var null|Club $object */
        return $object;
    }
}
