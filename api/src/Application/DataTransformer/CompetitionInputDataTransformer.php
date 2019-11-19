<?php

namespace App\Application\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Domain\DTO\CompetitionInput;
use App\Domain\Entity\Competition;
use App\Domain\Factory\CompetitionFactory;
use App\Domain\Validation\ValidationGroups;
use App\Infrastructure\ApiPlatform\OperationResolver;
use Webmozart\Assert\Assert;

class CompetitionInputDataTransformer implements DataTransformerInterface
{
    private $validator;
    private $competitionFactory;
    private $operationResolver;

    public function __construct(
        ValidatorInterface $validator,
        CompetitionFactory $competitionFactory,
        OperationResolver $operationResolver
    ) {
        $this->validator = $validator;
        $this->competitionFactory = $competitionFactory;
        $this->operationResolver = $operationResolver;
    }

    public function transform($object, string $to, array $context = [])
    {
        /** @var CompetitionInput $object */
        Assert::isInstanceOf($object, CompetitionInput::class);

        $this->validator->validate($object, ['groups' => $this->getValidationGroups($context)]);

        return $this->competitionFactory->fromCompetitionInput($object);
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        if ($data instanceof Competition) {
            return false;
        }

        return Competition::class === $to && null !== ($context['input']['class'] ?? null);
    }

    private function getValidationGroups(array $context): array
    {
        $validationGroups = ["Default"];

        switch ($this->operationResolver->getFromContext($context)) {
            case "put":
                $validationGroups[] = ValidationGroups::COMPETITION_PUT;

                break;
            case "post":
                $validationGroups[] = ValidationGroups::COMPETITION_POST;

                break;
        }

        $validationGroups[] = ValidationGroups::CITY_CLASS;

        Assert::same(3, \count($validationGroups));

        return $validationGroups;
    }
}
