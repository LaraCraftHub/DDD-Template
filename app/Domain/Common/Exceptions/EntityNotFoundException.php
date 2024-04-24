<?php

declare(strict_types=1);

namespace App\Domain\Common\Exceptions;

use DomainException;

final class EntityNotFoundException extends DomainException
{
    private function __construct(string $message)
    {
        parent::__construct($message, 404);
    }

    public static function fromId(string $modelClassName, int $id): self
    {
        return new self($modelClassName . ' not found with id=' . $id);
    }

    public static function withMessage(string $message): self
    {
        return new self($message);
    }
}
