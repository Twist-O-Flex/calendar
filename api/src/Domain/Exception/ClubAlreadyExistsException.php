<?php

namespace App\Domain\Exception;

use Ramsey\Uuid\UuidInterface;
use Throwable;

class ClubAlreadyExistsException extends \DomainException
{
    private $clubId;

    public function __construct(UuidInterface $clubId, $message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->clubId = $clubId;
    }

    public function getClubId(): UuidInterface
    {
        return $this->clubId;
    }
}
