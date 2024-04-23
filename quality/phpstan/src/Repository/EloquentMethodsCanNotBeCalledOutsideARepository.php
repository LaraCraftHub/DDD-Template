<?php

declare(strict_types=1);

namespace Quality\PHPStan\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use Quality\PHPStan\Trait\IsInTestsNamespaceTrait;

use function in_array;

final class EloquentMethodsCanNotBeCalledOutsideARepository implements Rule
{
    use IsInTestsNamespaceTrait;

    public function getNodeType(): string
    {
        return MethodCall::class;
    }

    /**
     * @param MethodCall $node
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if ($this->isInTestsNamespace($scope)) {
            return [];
        }

        if ($node->name instanceof Node\Identifier
            && ! $this->isWhitelisted($scope)
            && $this->isAnEloquentMethod($node)
            && $this->isMethodCalledOutsideARepository($scope)
            && $this->isMethodCalledOnAnEloquentModelOrRelation($node, $scope)
        ) {
            return [
                'Eloquent models/relations methods MUST be called inside a Repository',
            ];
        }

        /**
         * This is temporary to split in baseline during cleaning, it will be merged
         */
        if ($node->name instanceof Node\Identifier
            && ! $this->isWhitelisted($scope)
            && $this->isAnEloquentMethodNew($node)
            && $this->isMethodCalledOutsideARepository($scope)
            && $this->isMethodCalledOnAnEloquentModelOrRelation($node, $scope)
        ) {
            return [
                'Eloquent models/relations methods MUST be called inside a Repository (new batch)',
            ];
        }

        return [];
    }

    // TODO: create a helper class with common methods
    private function isMethodCalledOnAnEloquentModelOrRelation(MethodCall $node, Scope $scope): bool
    {
        $objectNode = $node->var;

        foreach ($scope->getType($objectNode)->getReferencedClasses() as $class) {
            if (is_subclass_of($class, Relation::class)
                || is_subclass_of($class, Model::class)
            ) {
                return true;
            }
        }

        return false;
    }

    // TODO: create a helper class with common methods
    private function isMethodCalledOutsideARepository(Scope $scope): bool
    {
        $currentClassName = $scope->getClassReflection()->getName();

        $currentClassIsARepository = str_starts_with($currentClassName, 'App\\Infrastructure\\')
            && str_ends_with($currentClassName, 'Repository');

        return ! $currentClassIsARepository;
    }

    private function isAnEloquentMethod(MethodCall|Node $node): bool
    {
        return in_array(
            $node->name->name,
            [
                'save',
                'update',
                'delete',
                'forceDelete',
                'attach',
                'sync',
                'detach',
                'updateExistingPivot',
                'syncWithoutDetaching',
            ],
        );
    }

    private function isAnEloquentMethodNew(MethodCall|Node $node): bool
    {
        return in_array(
            $node->name->name,
            [
                'getRelation',
                'getRelations',
                'getTouchedRelations',
                'relationLoaded',
                'setTouchedRelations',
                'setRelation',
                'setRelations',
                'unsetRelation',
                'unsetRelations',
                'withoutRelations',
            ],
        );
    }

    private function isWhitelisted(Scope $scope): bool
    {
        $currentClassName = $scope->getClassReflection()->getName();

        return str_starts_with($currentClassName, 'App\\Application\\Console\\Commands');
    }
}
