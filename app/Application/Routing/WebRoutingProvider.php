<?php

declare(strict_types=1);

namespace App\Application\Routing;

use App\Application\Routing\Web\Admin\WelcomeRouteMapper;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

final class WebRoutingProvider extends RouteServiceProvider
{
    /** @var RouteMapper[] */
    private readonly array $routeMappers;

    public function __construct(Application $app)
    {
        parent::__construct($app);
        // Declare all route mappers
        $this->routeMappers = [
            new WelcomeRouteMapper(),
        ];
    }

    public function map(): void
    {
        Route::group([
            'middleware' => ['web', 'auth', 'admin'],
            'prefix' => 'admin',
            'as' => 'admin.',
        ], function (Router $router): void {
            foreach ($this->routeMappers as $routeMapper) {
                $routeMapper->map($router);
            }
        });
    }
}
