<?php

declare(strict_types=1);

namespace Quality\PHPStan\Testing;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Node\InClassNode;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPUnit\Framework\TestCase;

final class TestSetUpAndTearDownVisibilityRule implements Rule
{
    public function getNodeType(): string
    {
        return InClassNode::class;
    }

    /**
     * @param InClassNode $node
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if (! $node->getClassReflection()->isSubclassOf(TestCase::class)) {
            return [];
        }

        $errors = [];
        foreach ([
            'setUp',
            'tearDown',
        ] as $methodName) {
            $method = $node->getClassReflection()->getMethod($methodName, $scope);
            if ($method->getDeclaringClass() !== $node->getClassReflection()) {
                continue;
            }

            if (! $method->isPublic()) {
                continue;
            }

            $errors[] = RuleErrorBuilder::message("\"$methodName()\" visibility MUST BE protected and not public")
                ->nonIgnorable()
                ->build();
        }

        return $errors;
    }
}
