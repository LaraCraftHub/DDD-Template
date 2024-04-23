<?php

declare(strict_types=1);

namespace Quality\PHPStan\Repository;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Node\InClassNode;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use Quality\PHPStan\Trait\IsInTestsNamespaceTrait;
use ReflectionClass;

final class InjectDomainRepositoryRule implements Rule
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
        if (! $classReflection->hasMethod('__construct') || $this->isRepositoryClass($classReflection->getNativeReflection())) {
            return [];
        }

        $errors = [];
        foreach ($classReflection->getMethod('__construct', $scope)->getVariants() as $variant) {
            foreach ($variant->getParameters() as $parameter) {
                foreach ($parameter->getType()->getReferencedClasses() as $referencedClass) {
                    if ($this->isRepositoryClass(new ReflectionClass($referencedClass))) {
                        $errors[] = RuleErrorBuilder::message("The \"\${$parameter->getName()}\" argument MUST reference \"$referencedClass\" by its domain interface, not its concrete implementation")
                            ->nonIgnorable()
                            ->build();
                    }
                }
            }
        }

        return $errors;
    }

    private function isRepositoryClass(ReflectionClass $reflectionClass): bool
    {
        return ! $reflectionClass->isInterface()
            && ! $reflectionClass->isTrait()
            && ! $reflectionClass->isEnum()
            && str_starts_with($reflectionClass->getName(), 'App\\Infrastructure\\')
            && str_ends_with($reflectionClass->getName(), 'Repository');
    }
}
