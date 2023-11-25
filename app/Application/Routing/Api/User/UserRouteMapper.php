<?php

declare(strict_types=1);

namespace App\Application\Routing\Api\User;

use App\Application\Http\Controllers\Api\Project\GetUserProjectsByStatusController;
use App\Application\Routing\RouteMapper;
use Illuminate\Routing\Router;

final class UserRouteMapper implements RouteMapper
{
    public function map(Router $router): void
    {
        $router->group([
            'as' => 'user.',
            'prefix' => 'user',
        ], static function (Router $router): void {
            $router->post('/{user}/projects', GetUserProjectsByStatusController::class)->name('projects');
        });
    }
}
