<?php

declare(strict_types=1);

namespace App\Infrastructure\Project\Repositories;

use App\Alias\EloquentCollection;
use App\Domain\Project\Repositories\ProjectRepository;
use App\Domain\User\User;
use Override;

final class EloquentProjectRepository implements ProjectRepository
{
    #[Override]
    public function getAllUserProjectsWithTrashedOnes(User $user): EloquentCollection
    {
        return $user
            ->projects()
            ->withTrashed()
            ->get();
    }
}
