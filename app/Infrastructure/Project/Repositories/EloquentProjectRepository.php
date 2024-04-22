<?php

declare(strict_types=1);

namespace App\Infrastructure\Project\Repositories;

use App\Domain\Project\Repositories\ProjectRepository;
use App\Domain\User\User;
use Illuminate\Support\Collection;
use Override;

final class EloquentProjectRepository implements ProjectRepository
{
    #[Override]
    public function getAllUserProjectsWithTrashedOnes(User $user): Collection
    {
        return $user
            ->projects()
            ->withTrashed()
            ->get();
    }
}
