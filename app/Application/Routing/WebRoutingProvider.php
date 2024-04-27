<?php

declare(strict_types=1);

namespace App\Application\Routing;

use App\Application\Routing\Web\Admin\WelcomeRouteMapper;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

final readonly class WebRoutingProvider
{
    /** @var RouteMapper[] */
    private array $routeMappers;

    public function __construct()
    {
        // Declare all route mappers
        $this->routeMappers = [
            new WelcomeRouteMapper(),
        ];
    }

    public function __invoke(): void
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
