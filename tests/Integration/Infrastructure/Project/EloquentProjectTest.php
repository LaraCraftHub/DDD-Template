<?php

declare(strict_types=1);

namespace Tests\Integration\Infrastructure\Project;

use App\Domain\Project\Project;
use App\Domain\User\User;
use App\Domain\UserProject\UserProject;
use Tests\Integration\IntegrationTestCase;

final class EloquentProjectTest extends IntegrationTestCase
{
    public function test_it_attach_users_to_a_project(): void
    {
        // Arrange
        $project = Project::factory()->create();
        $users = User::factory(2)->create();

        // Act
        $project->users()->sync($users);
        $project->load('users');

        // Assert
        $this->assertCount(2, $project->users);
        $this->assertInstanceOf(UserProject::class, $project->users->first()->getRelationValue('pivot'));
    }
}
