<?php

declare(strict_types=1);

namespace App\Application\Routing;

use App\Application\Routing\Api\Project\ProjectRouteMapper;
use App\Application\Routing\Api\User\UserRouteMapper;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

final readonly class ApiRoutingProvider
{
    /** @var RouteMapper[] */
    private array $routeMappers;

    public function __construct()
    {
        // Declare all route mappers
        $this->routeMappers = [
            new ProjectRouteMapper(),
            new UserRouteMapper(),
        ];
    }

    public function __invoke(): void
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
