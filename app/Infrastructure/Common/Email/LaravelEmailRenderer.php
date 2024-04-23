<?php

declare(strict_types=1);

namespace App\Infrastructure\Common\Email;

use App\Domain\Common\Email\EmailRenderer;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Mail\Markdown;

final readonly class LaravelEmailRenderer implements EmailRenderer
{
    public function __construct(private ViewFactory $viewFactory, private Markdown $markdownRenderer)
    {
    }

    public function render(string $templateView, array $data): string
    {
        return $this->viewFactory->make($templateView, $data)->render();
    }

    public function renderWithMarkdown(string $templateView, array $data): string
    {
        return $this->markdownRenderer->render($templateView, $data)->toHtml();
    }
}
