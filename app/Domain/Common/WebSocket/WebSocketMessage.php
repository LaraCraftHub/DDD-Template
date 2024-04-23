<?php

declare(strict_types=1);

namespace App\Domain\Common\WebSocket;

interface WebSocketMessage
{
    public function toArray(): array;
}
