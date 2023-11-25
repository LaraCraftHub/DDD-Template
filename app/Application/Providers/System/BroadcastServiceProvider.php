<?php

declare(strict_types=1);

namespace app\Application\Providers\System;

use App\Application\Broadcasting\UserChannel;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Broadcast::routes(/* ['middleware' => 'api'] */);

        Broadcast::channel('user.{user}', UserChannel::class);
    }
}
