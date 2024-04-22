<?php

declare(strict_types=1);

namespace App\Application\Providers\Project;

use App\Domain\Project\Repositories\ProjectRepository;
use App\Infrastructure\Project\Repositories\EloquentProjectRepository;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Override;

final class ProjectServiceProvider extends ServiceProvider implements DeferrableProvider
{
    #[Override]
    public function register(): void
    {
        $this->app->bind(ProjectRepository::class, EloquentProjectRepository::class);
    }

    /**
     * @return array<class-string>
     */
    #[Override]
    public function provides(): array
    {
        return [EloquentProjectRepository::class];
    }
}
