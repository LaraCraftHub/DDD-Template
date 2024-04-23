<?php

declare(strict_types=1);

namespace Quality\PHPStan\Testing;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Node\InClassNode;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\ShouldNotHappenException;
use Tests\Integration\IntegrationTestCase;
use Tests\Unit\UnitTestCase;

final class TestClassRules implements Rule
{
    public function getNodeType(): string
    {
        return InClassNode::class;
    }

    /**
     * @param InClassNode $node
     *
     * @throws ShouldNotHappenException
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $classReflection = $node->getClassReflection();

        $className = $classReflection->getName();

        $isAnIntegrationTest = (bool) preg_match("/^Tests\\\Integration\\\.*Test$/", $className);
        if ($isAnIntegrationTest) {
            return $this->processIntegrationTestNode($classReflection);
        }

        $isAUnitTest = (bool) preg_match("/^Tests\\\Unit\\\.*Test$/", $className);
        if ($isAUnitTest) {
            return $this->processUnitTestNode($classReflection);
        }

        $isATest = (bool) preg_match("/^Tests\\\.*Test$/", $className);
        if ($isATest) {
            return [
                RuleErrorBuilder::message('All tests MUST be in Tests/Unit or Tests/Integration directories')
                    ->nonIgnorable()
                    ->build(),
            ];
        }

        $isAConcreteTestClassThatIsNotSuffixedWithTest = ! str_ends_with($className, 'Test')
            && ! $classReflection->isAbstract()
            && ($classReflection->isSubclassOf(IntegrationTestCase::class) || $classReflection->isSubclassOf(UnitTestCase::class));
        if ($isAConcreteTestClassThatIsNotSuffixedWithTest) {
            return [
                RuleErrorBuilder::message('All tests classes MUST be suffixed with "Test"')
                    ->nonIgnorable()
                    ->build(),
            ];
        }

        return [];
    }

    private function processIntegrationTestNode(ClassReflection $classReflection): array
    {
        $inheritsFromIntegrationTestCase = is_subclass_of($classReflection->getName(), IntegrationTestCase::class);
        if (! $inheritsFromIntegrationTestCase) {
            return [
                RuleErrorBuilder::message('An integration test MUST extend ' . IntegrationTestCase::class)
                    ->nonIgnorable()
                    ->build(),
            ];
        }

        return [];
    }

    private function processUnitTestNode(ClassReflection $classReflection): array
    {
        $inheritsFromUnitTestCase = is_subclass_of($classReflection->getName(), UnitTestCase::class);
        if (! $inheritsFromUnitTestCase) {
            return [
                RuleErrorBuilder::message('A unit test MUST extend ' . UnitTestCase::class)
                    ->nonIgnorable()
                    ->build(),
            ];
        }

        return [];
    }
}
