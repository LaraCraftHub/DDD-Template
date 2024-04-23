<?php

declare(strict_types=1);

namespace App\Domain\Common\Email;

use InvalidArgumentException;

use const FILTER_VALIDATE_EMAIL;

final readonly class EmailAddress
{
    private function __construct(public string $value)
    {
    }

    public static function fromEmailAndName(string $email, string $name): self
    {
        self::validateEmail($email);

        return new self("$name <$email>");
    }

    public static function fromEmail(string $email): self
    {
        self::validateEmail($email);

        return new self($email);
    }

    public static function fromEmails(string $emails): self
    {
        foreach (explode(',', $emails) as $email) {
            self::validateEmail($email);
        }

        return new self($emails);
    }

    private static function validateEmail(string $email): void
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new InvalidArgumentException("The email '{$email}' is invalid, you must provide a valid email address");
        }
    }
}
