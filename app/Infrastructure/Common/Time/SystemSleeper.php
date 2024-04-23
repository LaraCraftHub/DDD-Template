<?php

declare(strict_types=1);

namespace App\Infrastructure\Common\Time;

use Override;
use App\Domain\Common\Time\Sleeper;

final readonly class SystemSleeper implements Sleeper
{
    #[Override]
    public function usleep(int $microseconds): void
    {
        usleep($microseconds);
    }
}
