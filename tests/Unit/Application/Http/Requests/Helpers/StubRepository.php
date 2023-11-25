<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Http\Requests\Helpers;

use Illuminate\Database\Eloquent\Model;

use function array_key_exists;
use function in_array;

final class StubRepository
{
    /** @var array<string, array<int|string, Model>> */
    private static array $repository = [];

    /**
     * <code>
     * Important: Each model you add to the repository should have a
     * unique id otherwise you'll just override the model within the repository.
     * If you are using a ModelBuilder be sure to build it `->withId(?) || ->withUuid(?)`
     * </code>
     */
    public static function addToRepository(Model $model): void
    {
        $table = $model->getTable();
        if (str_starts_with($table, 'stub_')) {
            $table = str_replace('stub_', '', $table);
        }

        if (! array_key_exists($table, self::$repository)) {
            self::$repository[$table] = [];
        }

        $id = $model->{$model->getKeyName()};
        self::$repository[$table][$id] = $model;
    }

    /**
     * @param array<int, int|string> $extraParameters
     */
    public static function exists(string $tableName, int|string $columnId, array $extraParameters = []): bool
    {
        if (! array_key_exists($tableName, self::$repository)) {
            return false;
        }

        if ($extraParameters !== []) {
            $extraColumnName = $extraParameters[0];
            $extraColumnValue = strtolower((string) $extraParameters[1]) === 'null' ? null : $extraParameters[1];

            return array_key_exists($columnId, self::$repository[$tableName])
                && self::$repository[$tableName][$columnId]->$extraColumnName === $extraColumnValue;
        }

        return array_key_exists($columnId, self::$repository[$tableName]);
    }

    /**
     * @param array<int, int|string> $columnIds
     * @param array<int, int|string> $extraParameters
     */
    public static function allExist(string $tableName, array $columnIds, array $extraParameters = []): bool
    {
        $truthTable = [];
        foreach ($columnIds as $columnId) {
            $truthTable[] = self::exists($tableName, $columnId, $extraParameters);
        }

        return ! in_array(false, $truthTable, true);
    }

    public static function has(string $tableName, string $columnName, string $value): bool
    {
        if (! array_key_exists($tableName, self::$repository)) {
            return false;
        }

        foreach (self::$repository[$tableName] as $model) {
            if (! $model->$columnName) {
                continue;
            }

            if ($value !== $model->$columnName) {
                continue;
            }

            if ($model->getAttributeValue('deleted_at') !== null) {
                continue;
            }

            return true;
        }

        return false;
    }

    public static function find(string $tableName, int $id): ?Model
    {
        if (! array_key_exists($tableName, self::$repository)) {
            return null;
        }

        foreach (self::$repository[$tableName] as $model) {
            if (! property_exists($model, 'id')) {
                continue;
            }

            if ($model->id === null) {
                continue;
            }

            if ($model->id !== $id) {
                continue;
            }

            return $model;
        }

        return null;
    }

    public static function clearRepository(): void
    {
        self::$repository = [];
    }
}
