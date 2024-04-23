<?php

declare(strict_types=1);

namespace App\Infrastructure\Common\Event;

use Override;
use App\Domain\Common\Event\Event;
use App\Domain\Common\Event\EventDispatcher;
use Illuminate\Contracts\Events\Dispatcher;

final readonly class LaravelEventDispatcher implements EventDispatcher
{
    public function __construct(private Dispatcher $dispatcher)
    {
    }

    #[Override]
    public function dispatch(Event $event): void
    {
        $this->dispatcher->dispatch($event);
    }
}
