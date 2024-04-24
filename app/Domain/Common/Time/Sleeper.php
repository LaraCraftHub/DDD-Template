<?php

declare(strict_types=1);

namespace App\Domain\Common\Time;

interface Sleeper
{
    public function usleep(int $microseconds): void;
}
