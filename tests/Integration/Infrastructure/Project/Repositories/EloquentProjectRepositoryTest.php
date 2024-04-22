<?php

declare(strict_types=1);

namespace Tests\Integration\Infrastructure\Project\Repositories;

use App\Domain\Project\Project;
use App\Domain\Project\Repositories\ProjectRepository;
use App\Domain\User\User;
use Override;
use Tests\Integration\IntegrationTestCase;

final class EloquentProjectRepositoryTest extends IntegrationTestCase
{
    private ProjectRepository $sut;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->sut = $this->app->make(ProjectRepository::class);
    }

    public function test_it_fetches_all_user_projects_grouped_by_status(): void
    {
        // Arrange
        $progressingProject = Project::factory()->progressing()->create();
        $progressingDeletedProject = Project::factory()->progressing()->deleted()->create();
        $blockedProject = Project::factory()->blocked()->create();
        $terminatedProject = Project::factory()->terminated()->create();

        $user1 = User::factory()->create();

        $expectedProjectIds = [
            $progressingProject->id,
            $progressingDeletedProject->id,
            $blockedProject->id,
            $terminatedProject->id,
        ];
        $user1->projects()->sync($expectedProjectIds);

        User::factory()
            ->has(Project::factory())
            ->has(Project::factory()->progressing())
            ->create();

        // Act
        $result = $this->sut->getAllUserProjectsWithTrashedOnes($user1);

        // Assert
        $this->assertCount(4, $result);
        $this->assertEqualsCanonicalizing($expectedProjectIds, $result->pluck('id')->all());
    }
}
