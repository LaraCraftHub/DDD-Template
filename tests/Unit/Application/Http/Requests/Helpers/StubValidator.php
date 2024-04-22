<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Http\Requests\Helpers;

use Illuminate\Validation\Validator;
use Override;

use function array_slice;
use function is_array;

final class StubValidator extends Validator
{
    /**
     * @param array<string, mixed> $data
     * @param array<string, string> $rules
     */
    public function __construct(array $data, array $rules)
    {
        parent::__construct(new StubTranslator(), $data, $rules);
    }

    /**
     * @param string $attribute
     * @param mixed $value
     * @param array<int, int|string> $parameters
     */
    #[Override]
    public function validateExists($attribute, $value, $parameters): bool
    {
        $columnId = $value;
        $tableName = $parameters[0] ?? '';
        $columnName = $parameters[1] ?? '';
        $extraParameters = array_slice($parameters, 2);

        if ($attribute !== 'id' && ($columnName !== '' && $columnName !== 'id')) {
            return StubRepository::has((string) $tableName, (string) $columnName, $value);
        }

        if (is_array($columnId)) {
            return StubRepository::allExist((string) $tableName, $columnId, $extraParameters);
        }

        return StubRepository::exists((string) $tableName, $columnId, $extraParameters);
    }

    /**
     * @param string $attribute
     * @param string $value
     * @param array<int, int|string> $parameters
     */
    #[Override]
    public function validateUnique($attribute, $value, $parameters): bool
    {
        $tableName = $parameters[0] ?? '';
        $columnName = $parameters[1] ?? '';

        return ! (StubRepository::has((string) $tableName, (string) $columnName, $value));
    }
}
