<?php

declare(strict_types=1);

namespace Quality\PHPStan\Model;

use Illuminate\Database\Eloquent\Model;
use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Node\InClassNode;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use Quality\PHPStan\Trait\IsInTestsNamespaceTrait;

use function in_array;

final class DateRules implements Rule
{
    use IsInTestsNamespaceTrait;

    private const array ELOQUENT_DATE_TYPES = [
        'date',
        'datetime',
        'custom_datetime',
        'immutable_date',
        'immutable_datetime',
        'immutable_custom_datetime',
    ];

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
        $parentClass = $classReflection->getParentClass();
        if ($parentClass === null) {
            return [];
        }

        if ($parentClass->getName() !== Model::class) {
            return [];
        }

        $nativeReflection = $classReflection->getNativeReflection();
        $needsDateFormat = false;
        foreach ($nativeReflection->getProperty('casts')->getDefaultValue() as $cast) {
            if (in_array($cast, self::ELOQUENT_DATE_TYPES, true)) {
                $needsDateFormat = true;

                break;
            }
        }

        if (! $needsDateFormat) {
            return [];
        }

        if ($nativeReflection->getProperty('dateFormat')->getDefaultValue() === 'Y-m-d H:i:s') {
            return [];
        }

        return [
            RuleErrorBuilder::message(
                'The "'
                . $classReflection->getName()
                . '" model MUST override the "$dateFormat" property with the "Y-m-d H:i:s" value because it casts at least one property to date or datetime'
            )
                ->nonIgnorable()
                ->build(),
        ];
    }
}
