<?php

declare(strict_types=1);

namespace App\Domain\Common\WebSocket;

interface WebSocketMessage
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(): array;
}
