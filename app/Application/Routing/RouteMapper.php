<?php

declare(strict_types=1);

namespace App\Application\Routing;

use Illuminate\Routing\Router;

interface RouteMapper
{
    public function map(Router $router): void;
}
