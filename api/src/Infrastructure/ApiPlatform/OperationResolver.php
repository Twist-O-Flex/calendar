<?php

namespace App\Infrastructure\ApiPlatform;

class OperationResolver
{
    public function getFromContext(array $context): string
    {
        if (isset($context["item_operation_name"])) {
            return $context["item_operation_name"];
        }

        if (isset($context["collection_operation_name"])) {
            return $context["collection_operation_name"];
        }

        throw new \RuntimeException("Unable to resolve operation name from context: " . \serialize($context));
    }
}
