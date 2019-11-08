<?php

namespace App\Application\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Domain\DTO\CompetitionInput;
use App\Domain\Entity\Competition;
use App\Domain\Factory\CompetitionFactory;
use App\Domain\Validation\ValidationGroups;
use Webmozart\Assert\Assert;

class CompetitionInputDataTransformer implements DataTransformerInterface
{
    private $validator;
    private $competitionFactory;

    public function __construct(ValidatorInterface $validator, CompetitionFactory $competitionFactory)
    {
        $this->validator = $validator;
        $this->competitionFactory = $competitionFactory;
    }

    public function transform($object, string $to, array $context = [])
    {
        /** @var CompetitionInput $object */
        Assert::isInstanceOf($object, CompetitionInput::class);

        $this->validator->validate(
            $object,
            ['groups' => \array_merge(['Default'], ValidationGroups::COMPETITION_WRITE)]
        );

        return $this->competitionFactory->fromCompetitionInput($object);
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        if ($data instanceof Competition) {
            return false;
        }

        return Competition::class === $to && null !== ($context['input']['class'] ?? null);
    }
}
