<?php

declare(strict_types=1);

namespace Quality\PHPStan\Trait;

use PHPStan\Analyser\Scope;

trait IsInTestsNamespaceTrait
{
    private function isInTestsNamespace(Scope $scope): bool
    {
        return str_starts_with($scope->getNamespace(), 'Tests\\');
    }
}
