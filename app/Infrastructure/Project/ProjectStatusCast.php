<?php

declare(strict_types=1);

namespace App\Infrastructure\Project;

use App\Application\Exceptions\InvalidMixedValueException;
use App\Domain\Project\ProjectStatus;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

use function is_int;

/**
 * @implements CastsAttributes<ProjectStatus, mixed>
 */
final class ProjectStatusCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param array<string, mixed> $attributes
     *
     * @throws InvalidMixedValueException
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): ProjectStatus
    {
        if (! is_int($value) || ! ProjectStatus::tryFrom($value) instanceof ProjectStatus) {
            throw new InvalidMixedValueException('Cannot fetch a ProjectStatus value from "%s"', $value);
        }

        return ProjectStatus::from($value);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param array<string, mixed> $attributes
     *
     * @throws InvalidMixedValueException
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): int
    {
        if (! $value instanceof ProjectStatus) {
            throw new InvalidMixedValueException('The given value "%s" is not a ProjectStatus', $value);
        }

        return $value->value;
    }
}
