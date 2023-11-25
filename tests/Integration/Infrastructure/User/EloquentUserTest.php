<?php

declare(strict_types=1);

namespace Tests\Integration\Infrastructure\User;

use App\Domain\Project\Project;
use App\Domain\User\User;
use App\Domain\UserProject\UserProject;
use Tests\Integration\IntegrationTestCase;

final class EloquentUserTest extends IntegrationTestCase
{
    public function test_it_attach_projects_to_a_user(): void
    {
        // Arrange
        $user = User::factory()->create();
        $projects = Project::factory(2)->create();

        // Act
        $user->projects()->sync($projects);
        $user->load('projects');

        // Assert
        $this->assertCount(2, $user->projects);
        $this->assertInstanceOf(UserProject::class, $user->projects->first()->getRelationValue('pivot'));
    }
}
