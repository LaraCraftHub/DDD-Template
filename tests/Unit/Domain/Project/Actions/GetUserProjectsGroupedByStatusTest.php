<?php

declare(strict_types=1);

namespace tests\Unit\Domain\Project\Actions;

use App\Domain\Project\Actions\GetUserProjectsGroupedByStatus;
use App\Domain\Project\ProjectStatus;
use App\Domain\Project\Repositories\ProjectRepository;
use Illuminate\Support\Collection;
use Mockery;
use Mockery\MockInterface;
use Override;
use Tests\Builder\ProjectBuilder;
use Tests\Builder\UserBuilder;
use Tests\Unit\UnitTestCase;

final class GetUserProjectsGroupedByStatusTest extends UnitTestCase
{
    private GetUserProjectsGroupedByStatus $sut;

    private ProjectRepository&MockInterface $projectRepository;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->projectRepository = Mockery::mock(ProjectRepository::class);
        $this->sut = new GetUserProjectsGroupedByStatus($this->projectRepository);
    }

    public function test_it_groups_user_projects_by_status(): void
    {
        // Arrange
        $generatedProject = (new ProjectBuilder())->build();
        $progressingProject = (new ProjectBuilder())
            ->withInProgressStatus()
            ->build();
        $progressingDeletedProject = (new ProjectBuilder())
            ->deleted()
            ->withInProgressStatus()
            ->build();
        $blockedProject = (new ProjectBuilder())
            ->withBlockedStatus()
            ->build();
        $terminatedProject = (new ProjectBuilder())
            ->withTerminatedStatus()
            ->build();

        $user = (new UserBuilder())->build();

        $this->projectRepository
            ->shouldReceive('getAllUserProjectsWithTrashedOnes')
            ->andReturn(
                new Collection([
                    $generatedProject,
                    $progressingProject,
                    $progressingDeletedProject,
                    $blockedProject,
                    $terminatedProject,
                ])
            );

        // Act
        $result = ($this->sut)($user);

        // Assert
        $this->assertCount(1, $result->get(ProjectStatus::GENERATED->value));
        $this->assertCount(2, $result->get(ProjectStatus::IN_PROGRESS->value));
        $this->assertCount(1, $result->get(ProjectStatus::BLOCKED->value));
        $this->assertCount(1, $result->get(ProjectStatus::TERMINATED->value));
    }
}
