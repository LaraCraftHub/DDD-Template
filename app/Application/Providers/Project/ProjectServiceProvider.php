<?php

declare(strict_types=1);

namespace App\Application\Providers\Project;

use App\Domain\Project\Repositories\ProjectRepository;
use App\Infrastructure\Project\Repositories\EloquentProjectRepository;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

final class ProjectServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        $this->app->bind(ProjectRepository::class, EloquentProjectRepository::class);
    }

    /**
     * @return array<class-string>
     */
    public function provides(): array
    {
        return [EloquentProjectRepository::class];
    }
}
