<?php

declare(strict_types=1);

namespace App\Application\Routing\Api\Project;

use App\Application\Http\Controllers\Api\User\GetProjectUsersController;
use App\Application\Routing\RouteMapper;
use Illuminate\Routing\Router;

final class ProjectRouteMapper implements RouteMapper
{
    public function map(Router $router): void
    {
        $router->group([
            'as' => 'project.',
            'prefix' => 'project',
        ], static function (Router $router): void {
            $router->post('/{project}/users', GetProjectUsersController::class)->name('users');
        });
    }
}
