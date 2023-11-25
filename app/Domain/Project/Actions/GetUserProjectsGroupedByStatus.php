<?php

declare(strict_types=1);

namespace App\Domain\Project\Actions;

use App\Domain\Project\Project;
use App\Domain\Project\Repositories\ProjectRepository;
use App\Domain\User\User;
use Illuminate\Support\Collection;

readonly class GetUserProjectsGroupedByStatus
{
    public function __construct(private ProjectRepository $projectRepository)
    {
    }

    /**
     * @return Collection<int|string, Collection<int|string,Project>>
     */
    public function __invoke(User $user): Collection
    {
        return $this->projectRepository
            ->getAllUserProjectsWithTrashedOnes($user)
            ->groupBy(static fn (Project $project) => $project->status->value);
    }
}
