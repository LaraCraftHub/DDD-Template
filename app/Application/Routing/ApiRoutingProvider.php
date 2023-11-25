<?php

declare(strict_types=1);

namespace App\Application\Routing;

use App\Application\Routing\Api\Project\ProjectRouteMapper;
use App\Application\Routing\Api\User\UserRouteMapper;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

final class ApiRoutingProvider extends RouteServiceProvider
{
    /** @var RouteMapper[] */
    private readonly array $routeMappers;

    public function __construct(Application $app)
    {
        parent::__construct($app);
        // Declare all route mappers
        $this->routeMappers = [
            new ProjectRouteMapper(),
            new UserRouteMapper(),
        ];
    }

    public function map(): void
    {
        Route::group([
            'middleware' => ['api'], // 'auth:sanctum'
            'prefix' => 'api',
            'as' => 'api.',
        ], function (Router $router): void {
            foreach ($this->routeMappers as $routeMapper) {
                $routeMapper->map($router);
            }
        });
    }
}
