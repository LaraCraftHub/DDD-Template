<?php

declare(strict_types=1);

namespace App\Infrastructure\Common\Time;

use App\Domain\Common\Time\Sleeper;

final readonly class SystemSleeper implements Sleeper
{
    public function usleep(int $microseconds): void
    {
        usleep($microseconds);
    }
}
