<?php

declare(strict_types=1);

namespace App\Domain\Common\Exceptions;

use DomainException;

final class ValidationException extends DomainException
{
    private readonly array $messages;

    private function __construct(array $messages)
    {
        parent::__construct(implode(',', $messages));
        $this->messages = $messages;
    }

    public function getMessages(): array
    {
        return $this->messages;
    }

    public static function fromMessage(string $message): self
    {
        return new self([$message]);
    }

    public static function fromMessages(array $messages): self
    {
        return new self($messages);
    }
}
