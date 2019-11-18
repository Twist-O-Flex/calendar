<?php

namespace App\Application\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Domain\DTO\ClubInput;
use App\Domain\Entity\Club;
use App\Domain\Factory\ClubFactory;
use App\Domain\Repository\CityRepositoryInterface;
use App\Domain\Validation\ValidationGroups;
use Symfony\Component\Validator\Constraints\GroupSequence;
use Webmozart\Assert\Assert;

final class ClubInputDataTransformer implements DataTransformerInterface
{
    private $validator;
    private $clubFactory;
    private $cityRepository;

    public function __construct(
        ValidatorInterface $validator,
        ClubFactory $clubFactory,
        CityRepositoryInterface $cityRepository
    ) {
        $this->validator = $validator;
        $this->clubFactory = $clubFactory;
        $this->cityRepository = $cityRepository;
    }

    public function transform($object, string $to, array $context = [])
    {
        /** @var ClubInput $object */
        Assert::isInstanceOf($object, ClubInput::class);

        $this->validator->validate(
            $object,
            [
                'groups' => new GroupSequence(
                    \array_merge(['Default'], ValidationGroups::CLUB_WRITE, [ValidationGroups::CITY_DATA])
                )
            ]
        );

        $cityInput = $object->address->city;
        $city = $this->cityRepository->getCityByNameAndZipCode($cityInput->name, $cityInput->zipCode);

        $object->address->city->name = $city->getName();
        $object->address->city->zipCode = $city->getZipCode();

        return $this->clubFactory->fromClubInput($object);
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        if ($data instanceof Club) {
            return false;
        }

        return Club::class === $to && null !== ($context['input']['class'] ?? null);
    }
}
