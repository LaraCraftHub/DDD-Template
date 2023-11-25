<?php

declare(strict_types=1);

namespace App\Infrastructure\UserProject;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Infrastructure\UserProject\EloquentUserProject
 *
 * @method static Builder|EloquentUserProject newModelQuery()
 * @method static Builder|EloquentUserProject newQuery()
 * @method static Builder|EloquentUserProject query()
 * @method static Builder|EloquentUserProject whereProjectId($value)
 * @method static Builder|EloquentUserProject whereUserId($value)
 *
 * @mixin \Eloquent
 */
class EloquentUserProject extends Pivot
{
}
