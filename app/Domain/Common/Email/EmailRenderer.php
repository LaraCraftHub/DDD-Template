<?php

declare(strict_types=1);

namespace App\Domain\Common\Email;

interface EmailRenderer
{
    public function render(string $templateView, array $data): string;

    public function renderWithMarkdown(string $templateView, array $data): string;
}
