<?php

namespace App\Application\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Domain\DTO\CompetitionInput;
use App\Domain\Entity\Competition;
use App\Domain\Repository\ClubRepository;
use App\Domain\Validation\ValidationGroups;
use Webmozart\Assert\Assert;

class CompetitionInputDataTransformer implements DataTransformerInterface
{
    private $validator;
    private $clubRepository;

    public function __construct(ValidatorInterface $validator, ClubRepository $clubRepository)
    {
        $this->validator = $validator;
        $this->clubRepository = $clubRepository;
    }

    public function transform($object, string $to, array $context = [])
    {
        /** @var CompetitionInput $object */
        Assert::isInstanceOf($object, CompetitionInput::class);

        $this->validator->validate(
            $object,
            ['groups' => array_merge(['Default'], ValidationGroups::COMPETITION_WRITE)]
        );

        return (new Competition())
            ->setType($object->type)
            ->setFormation($object->formation)
            ->setClub($this->clubRepository->find($object->club->id))
            ->setStartDate(new \DateTimeImmutable($object->startDate))
            ->setDuration($object->duration)
            ->setQuotation($object->quotation);
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        if ($data instanceof Competition) {
            return false;
        }

        return Competition::class === $to && null !== ($context['input']['class'] ?? null);
    }
}
