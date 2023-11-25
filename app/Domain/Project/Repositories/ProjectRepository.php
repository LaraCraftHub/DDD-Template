<?php

declare(strict_types=1);

namespace App\Domain\Project\Repositories;

use App\Domain\Project\Project;
use App\Domain\User\User;
use Illuminate\Support\Collection;

interface ProjectRepository
{
    /**
     * @return Collection<int,Project>
     */
    public function getAllUserProjectsWithTrashedOnes(User $user): Collection;
}
