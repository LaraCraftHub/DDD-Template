<?php

declare(strict_types=1);

namespace App\Domain\Common\Email;

interface EmailSender
{
    public function send(Email $email): void;
}
