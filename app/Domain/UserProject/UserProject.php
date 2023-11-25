<?php

declare(strict_types=1);

namespace App\Domain\UserProject;

use App\Domain\BusinessEntity;
use App\Infrastructure\UserProject\EloquentUserProject;

/**
 * App\Domain\UserProject\UserProject
 *
 * @property int $user_id
 * @property int $project_id
 *
 * @mixin \Eloquent
 */
class UserProject extends EloquentUserProject implements BusinessEntity
{
}
