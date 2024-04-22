<?php

declare(strict_types=1);

namespace App\Application\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Override;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    #[Override]
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     */
    #[Override]
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
    }
}
