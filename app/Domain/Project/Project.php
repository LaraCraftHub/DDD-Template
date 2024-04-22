<?php

declare(strict_types=1);

namespace App\Domain\Project;

use App\Domain\User\User;
use App\Infrastructure\Project\EloquentProject;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Domain\Project\Project
 *
 * @property int $id
 * @property string $title
 * @property ProjectStatus $status
 * @property float $funds in euro
 * @property CarbonImmutable|null $started_at
 * @property CarbonImmutable|null $blocked_at
 * @property CarbonImmutable|null $terminated_at
 * @property CarbonImmutable|null $deleted_at
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 *
 * Eloquent relations
 * @property-read Collection<int, User> $users
 * @property-read int|null $users_count
 *
 * @mixin Model
 */
class Project extends EloquentProject
{
    final public const array STATUSES = [
        ProjectStatus::GENERATED,
        ProjectStatus::IN_PROGRESS,
        ProjectStatus::BLOCKED,
        ProjectStatus::TERMINATED,
    ];

    final public const array FINISHED_STATUSES = [
        ProjectStatus::BLOCKED,
        ProjectStatus::TERMINATED,
    ];
}
