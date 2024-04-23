<?php

declare(strict_types=1);

namespace App\Domain\Project\Actions;

use App\Alias\EloquentCollection;
use App\Alias\SupportCollection;
use App\Domain\Project\Project;
use App\Domain\Project\Repositories\ProjectRepository;
use App\Domain\User\User;

readonly class GetUserProjectsGroupedByStatus
{
    public function __construct(private ProjectRepository $projectRepository)
    {
    }

    /**
     * @return EloquentCollection<int|string, EloquentCollection<int|string,Project>>
     * @phpstan-ignore-next-line EloquentCollection is a generic type <TKey, TModel> where TModel
     * extends \Illuminate\Database\Eloquent\Model but in this TModel is a an EloquentCollection due to the groupBY
     */
    public function __invoke(User $user): EloquentCollection
    {
        // @phpstan-ignore-next-line Same reason as the above
        return $this->projectRepository
            ->getAllUserProjectsWithTrashedOnes($user)
            ->groupBy(static fn (Project $project) => $project->status->value);
    }
}
