<?php

declare(strict_types=1);

namespace App\Domain\Common;

use App\Domain\Common\Exceptions\ValidationException;

final readonly class PositiveInteger
{
    private function __construct(public int $value)
    {
        if ($value < 0) {
            throw ValidationException::fromMessage("The given value $this->value must be a positive integer.");
        }
    }

    public static function fromValue(int $value): self
    {
        return new self($value);
    }
}
