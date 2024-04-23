<?php

declare(strict_types=1);

namespace Quality\PHPStan\Repository;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Node\InClassNode;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use Quality\PHPStan\Trait\IsInTestsNamespaceTrait;
use ReflectionMethod;

use function count;

final class RepositoryRules implements Rule
{
    use IsInTestsNamespaceTrait;

    public function getNodeType(): string
    {
        return InClassNode::class;
    }

    /**
     * @param InClassNode $node
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if ($this->isInTestsNamespace($scope)) {
            return [];
        }

        $classReflection = $node->getClassReflection();
        if (! $this->isRepositoryClass($classReflection)) {
            return [];
        }

        $interfaceReflections = array_values(array_filter(
            $classReflection->getInterfaces(),
            $this->isRepositoryInterface(...),
        ));
        if (count($interfaceReflections) !== 1) {
            return [
                RuleErrorBuilder::message("\"{$classReflection->getName()}\" MUST implement 1 interface from the Domain layer")
                    ->nonIgnorable()
                    ->build(),
            ];
        }

        $errors = [];
        foreach (array_diff(
            $this->getPublicMethodsNames($classReflection),
            $this->getPublicMethodsNames($interfaceReflections[0]),
        ) as $methodName) {
            if ($methodName === '__construct') {
                continue;
            }

            $errors[] = RuleErrorBuilder::message("The \"$methodName\" method MUST be added to the Domain layer interface or MUST NOT be public")
                ->nonIgnorable()
                ->build();
        }

        return $errors;
    }

    private function isRepositoryClass(ClassReflection $classReflection): bool
    {
        return $classReflection->isClass()
            && str_starts_with($classReflection->getName(), 'App\\Infrastructure\\')
            && str_ends_with($classReflection->getName(), 'Repository');
    }

    private function isRepositoryInterface(ClassReflection $classReflection): bool
    {
        return $classReflection->isInterface()
            && str_starts_with($classReflection->getName(), 'App\\Domain\\')
            && str_ends_with($classReflection->getName(), 'Repository');
    }

    /**
     * @return string[]
     */
    private function getPublicMethodsNames(ClassReflection $classReflection): array
    {
        return array_map(
            static fn (ReflectionMethod $reflectionMethod): string => $reflectionMethod->name,
            $classReflection->getNativeReflection()->getMethods(ReflectionMethod::IS_PUBLIC),
        );
    }
}
