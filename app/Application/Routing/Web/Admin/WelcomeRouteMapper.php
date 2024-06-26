<?php

declare(strict_types=1);

namespace App\Application\Routing\Web\Admin;

use App\Application\Routing\RouteMapper;
use Illuminate\Routing\Router;
use Override;

final class WelcomeRouteMapper implements RouteMapper
{
    #[Override]
    public function map(Router $router): void
    {
        $router->get('/', static fn () => view('welcome'));
    }
}
