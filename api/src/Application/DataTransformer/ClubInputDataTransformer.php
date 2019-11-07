<?php

namespace App\Application\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Domain\DTO\ClubInput;
use App\Domain\Entity\Club;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Domain\Validation\ValidationGroups;
use Webmozart\Assert\Assert;

final class ClubInputDataTransformer implements DataTransformerInterface
{
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function transform($object, string $to, array $context = [])
    {
        /** @var ClubInput $object */
        Assert::isInstanceOf($object, ClubInput::class);

        $this->validator->validate($object, ['groups' => array_merge(['Default'], ValidationGroups::CLUB_WRITE)]);

        return (new Club())
            ->setName($object->name)
            ->setAddress($object->address)
            ->setContact($object->contact);
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        if ($data instanceof Club) {
            return false;
        }

        return Club::class === $to && null !== ($context['input']['class'] ?? null);
    }
}
