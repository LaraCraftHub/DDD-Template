<?php

declare(strict_types=1);

namespace App\Infrastructure\Common\Email;

use App\Domain\Common\Email\EmailRenderer;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Mail\Markdown;
use Override;

final readonly class LaravelEmailRenderer implements EmailRenderer
{
    public function __construct(private ViewFactory $viewFactory, private Markdown $markdownRenderer)
    {
    }

    #[Override]
    public function render(string $templateView, array $data): string
    {
        return $this->viewFactory->make($templateView, $data)->render();
    }

    #[Override]
    public function renderWithMarkdown(string $templateView, array $data): string
    {
        return $this->markdownRenderer->render($templateView, $data)->toHtml();
    }
}
