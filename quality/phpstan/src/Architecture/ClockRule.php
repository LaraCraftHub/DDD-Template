<?php

declare(strict_types=1);

namespace Quality\PHPStan\Architecture;

use PhpParser\Node;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Name;
use PhpParser\Node\Scalar\String_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\ShouldNotHappenException;
use Quality\PHPStan\Trait\IsInTestsNamespaceTrait;

final class ClockRule implements Rule
{
    use IsInTestsNamespaceTrait;

    public function getNodeType(): string
    {
        return New_::class;
    }

    /**
     * @param New_ $node
     *
     * @throws ShouldNotHappenException
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if ($this->isInTestsNamespace($scope)) {
            return [];
        }

        if (! $node->class instanceof Name) {
            return [];
        }

        if ($node->class->toString() !== 'DateTimeImmutable') {
            return [];
        }

        // Simple check if there are no args or if the first arg === 'now'
        // It's impossible to handle all bad cases (eg: using a variable, "+1 hour", etc.) but that
        // cover the two most common ones
        if ($node->args === []) {
            $new = 'new \DateTimeImmutable()';
        } else {
            $firstArg = reset($node->args);
            if (! $firstArg->value instanceof String_ || strtolower($firstArg->value->value) !== 'now') {
                return [];
            }

            $new = "new \DateTimeImmutable('now')";
        }

        return [
            RuleErrorBuilder::message("Using $new is forbidden, please read
             https://laravel-ddd-guidelines.dev/architecture/clock")
                ->build(),
        ];
    }
}
