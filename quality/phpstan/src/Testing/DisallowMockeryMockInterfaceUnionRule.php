<?php

declare(strict_types=1);

namespace Quality\PHPStan\Testing;

use Mockery\MockInterface;
use PhpParser\Node;
use PhpParser\Node\Identifier;
use PhpParser\Node\IntersectionType;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Property;
use PhpParser\Node\UnionType;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

final class DisallowMockeryMockInterfaceUnionRule implements Rule
{
    public function getNodeType(): string
    {
        return Property::class;
    }

    /**
     * @param Property $node
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if (! $node->type instanceof UnionType) {
            return [];
        }

        foreach ($this->getTypesNames($node->type->types) as $name) {
            if ($name->toString() !== MockInterface::class) {
                continue;
            }

            $propertyName = $node->props[0]->name->toString();

            return [
                RuleErrorBuilder::message("Property $$propertyName SHOULD intersect MockInterface: use &MockInterface instead of |MockInterface.")
                    ->build(),
            ];
        }

        return [];
    }

    /**
     * @param (Identifier|Name|IntersectionType)[] $types
     * @return Name[]
     */
    private function getTypesNames(array $types): array
    {
        $names = [];
        foreach ($types as $type) {
            if ($type instanceof IntersectionType) {
                $names = [...$names, ...$this->getTypesNames($type->types)];

                continue;
            }

            if ($type instanceof Name) {
                $names[] = $type;
            }
        }

        return $names;
    }
}
