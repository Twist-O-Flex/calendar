<?php

namespace App\Domain\Factory;

use App\Domain\DTO\CompetitionInput;
use App\Domain\Entity\Competition;
use App\Domain\Repository\ClubRepositoryInterface;
use Webmozart\Assert\Assert;

class CompetitionFactory
{
    private $clubRepository;

    public function __construct(ClubRepositoryInterface $clubRepository)
    {
        $this->clubRepository = $clubRepository;
    }

    public function fromCompetitionInput(CompetitionInput $competitionInput): Competition
    {
        Assert::notNull($club = $this->clubRepository->find($competitionInput->club->id));

        return (new Competition())
            ->setType($competitionInput->type)
            ->setFormation($competitionInput->formation)
            ->setClub($club)
            ->setStartDate(new \DateTimeImmutable($competitionInput->startDate))
            ->setDuration($competitionInput->duration)
            ->setQuotation($competitionInput->quotation);
    }
}
