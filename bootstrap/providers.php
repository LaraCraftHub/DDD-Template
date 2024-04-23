<?php

declare(strict_types=1);

return [
    /*
     * Application Service Providers...
     */
    App\Application\Providers\System\AppServiceProvider::class,
    App\Application\Providers\System\AuthServiceProvider::class,
    // App\Providers\BroadcastServiceProvider::class,
    App\Application\Providers\System\EventServiceProvider::class,
    App\Application\Providers\System\RouteServiceProvider::class,

    /*
     * Routing Service Providers
     */
    App\Application\Routing\WebRoutingProvider::class,
    App\Application\Routing\ApiRoutingProvider::class,

    /*
     * Domain Service Providers...
     */
    App\Application\Providers\CommonProvider::class,
    App\Application\Providers\Project\ProjectServiceProvider::class,
    App\Application\Providers\User\UserServiceProvider::class,
];
