<?php

declare(strict_types=1);

namespace App\Domain\Common\Email;

interface EmailRenderer
{
    /**
     * @param array<string, mixed> $data
     */
    public function render(string $templateView, array $data): string;

    /**
     * @param array<string, mixed> $data
     */
    public function renderWithMarkdown(string $templateView, array $data): string;
}
