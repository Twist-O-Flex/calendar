<?php

namespace App\Application\DataTransformer\Club;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Application\DataTransformer\Club\Traits\DataTransformerSupportClub;
use App\Application\DataTransformer\Club\Traits\HydrateClubInputTrait;
use App\Domain\DTO\ClubInput;
use App\Domain\Entity\Club;
use App\Domain\Factory\ClubFactory;
use App\Domain\Identifier\ClubIdGenerator;
use App\Domain\Repository\CityRepositoryInterface;
use App\Domain\Validation\ValidationGroups;
use App\Infrastructure\Repository\ClubRepository;
use Symfony\Component\Validator\Constraints\GroupSequence;
use Webmozart\Assert\Assert;

class PutClubInputDataTransformer implements DataTransformerInterface
{
    use HydrateClubInputTrait;
    use DataTransformerSupportClub;

    private $validator;
    private $clubFactory;
    private $clubIdGenerator;
    private $clubRepository;

    public function __construct(
        ValidatorInterface $validator,
        CityRepositoryInterface $cityRepository,
        ClubFactory $clubFactory,
        ClubIdGenerator $clubIdGenerator,
        ClubRepository $clubRepository
    ) {
        $this->validator = $validator;
        $this->cityRepository = $cityRepository;
        $this->clubFactory = $clubFactory;
        $this->clubIdGenerator = $clubIdGenerator;
        $this->clubRepository = $clubRepository;
    }

    public function transform($object, string $to, array $context = [])
    {
        /** @var ClubInput $object */
        Assert::isInstanceOf($object, ClubInput::class);

        $this->validator->validate(
            $object,
            ["groups" => new GroupSequence(["Default", ValidationGroups::CLUB_PUT, ValidationGroups::CITY_CLASS])]
        );

        $this->hydrateCity($object);

        Assert::keyExists($context, "object_to_populate");
        Assert::isInstanceOf($context["object_to_populate"], Club::class);

        return $this->clubFactory->createOrHydrate($object, $context["object_to_populate"]);
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        if (!isset($context["item_operation_name"]) || "put" !== $context["item_operation_name"]) {
            return false;
        }

        return $this->supports($data, $to, $context);
    }
}
