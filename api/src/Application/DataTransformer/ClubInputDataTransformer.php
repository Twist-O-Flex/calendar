<?php

namespace App\Application\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Domain\DTO\ClubInput;
use App\Domain\Entity\Address;
use App\Domain\Entity\Club;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Domain\Entity\Contact;
use App\Domain\Factory\ClubFactory;
use App\Domain\Validation\ValidationGroups;
use Webmozart\Assert\Assert;

final class ClubInputDataTransformer implements DataTransformerInterface
{
    private $validator;
    private $clubFactory;

    public function __construct(ValidatorInterface $validator, ClubFactory $clubFactory)
    {
        $this->validator = $validator;
        $this->clubFactory = $clubFactory;
    }

    public function transform($object, string $to, array $context = [])
    {
        /** @var ClubInput $object */
        Assert::isInstanceOf($object, ClubInput::class);

        $this->validator->validate($object, ['groups' => array_merge(['Default'], ValidationGroups::CLUB_WRITE)]);

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
