<?php

declare(strict_types=1);

namespace App\Domain\Common\Event;

interface EventDispatcher
{
    public function dispatch(Event $event): void;
}
