<?php

declare(strict_types=1);

namespace App\Domain\Common\Email;

final readonly class Email
{
    public function __construct(
        private EmailAddress $to,
        private EmailAddress $from,
        private string $content,
        private string $subject,
    ) {
    }

    /**
     * @return array{email_to: string, email_from: string, content: string, subject: string}
     */
    public function toArray(): array
    {
        return [
            'email_to' => $this->to->value,
            'email_from' => $this->from->value,
            'content' => $this->content,
            'subject' => $this->subject,
        ];
    }
}
