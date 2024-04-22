<?php

declare(strict_types=1);

namespace App\Domain\UserProject;

use App\Infrastructure\UserProject\EloquentUserProject;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Domain\UserProject\UserProject
 *
 * @property int $user_id
 * @property int $project_id
 *
 * @mixin Model
 */
class UserProject extends EloquentUserProject
{
}
