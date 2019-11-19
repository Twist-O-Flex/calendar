<?php

namespace App\Application\DataTransformer\Club\Traits;

use App\Domain\Entity\Club;

trait DataTransformerSupportClub
{
    private function supports($data, string $to, array $context = []): bool
    {
        if ($data instanceof Club) {
            return false;
        }

        return Club::class === $to && null !== ($context['input']['class'] ?? null);
    }
}
