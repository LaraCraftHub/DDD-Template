<?php

declare(strict_types=1);

namespace App\Domain\Project\Repositories;

use App\Alias\EloquentCollection;
use App\Domain\Project\Project;
use App\Domain\User\User;

interface ProjectRepository
{
    /**
     * @return EloquentCollection<int,Project>
     */
    public function getAllUserProjectsWithTrashedOnes(User $user): EloquentCollection;
}
