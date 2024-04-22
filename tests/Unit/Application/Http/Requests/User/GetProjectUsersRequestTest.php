<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Http\Requests\User;

use App\Application\Http\Requests\User\GetProjectUsersRequest;
use Override;
use Tests\Builder\ProjectBuilder;
use Tests\Builder\UserBuilder;
use Tests\Unit\Application\Http\Requests\Helpers\StubRepository;
use Tests\Unit\Application\Http\Requests\RequestTestCase;

final class GetProjectUsersRequestTest extends RequestTestCase
{
    public function test_it_validates_request_when_provided_params_are_valid(): void
    {
        // Arrange
        $project = (new ProjectBuilder())
            ->withUser((new UserBuilder())->build())
            ->build();
        $params = [
            'project_title' => 'my_project_title',
            'email' => 'email@not.exisit',
        ];

        // Act && Assert
        $this->assertTrue(
            $this->validateWithRouteParameters(
                $params,
                ['project' => $project]
            ),
        );
    }

    public function test_it_does_not_validate_request_when_project_title_is_longer_than20_characters(): void
    {
        // Arrange
        $project = (new ProjectBuilder())
            ->withUser((new UserBuilder())->build())
            ->build();
        $params = [
            'project_title' => 'project_title_more_than_20_characters',
        ];

        // Act && Assert
        $this->assertFalse(
            $this->validateWithRouteParameters(
                $params,
                ['project' => $project]
            ),
        );
    }

    public function test_it_does_not_validate_request_when_email_is_not_unique(): void
    {
        // Arrange
        $user1 = (new UserBuilder())->withId(1)->withEmail('email1@example.com')->build();

        $user2 = (new UserBuilder())->withId(2)->withEmail('email2@example.com')->build();
        $project = (new ProjectBuilder())
            ->withUser($user2)
            ->build();

        StubRepository::addToRepository($user1);
        StubRepository::addToRepository($user2);

        $params = [
            'email' => 'email1@example.com',
        ];

        // Act && Assert
        $this->assertFalse(
            $this->validateWithRouteParameters(
                $params,
                ['project' => $project]
            ),
        );
    }

    public function test_it_does_not_validate_request_when_project_title_is_not_unique(): void
    {
        // Arrange
        $user = (new UserBuilder())->withId(1)->build();
        $project = (new ProjectBuilder())
            ->withId(1)
            ->withUser($user)
            ->withTitle('project_title_1')
            ->build();

        StubRepository::addToRepository($user);
        StubRepository::addToRepository($project);

        $params = [
            'project_title' => 'project_title_1',
        ];

        // Act && Assert
        $this->assertFalse(
            $this->validateWithRouteParameters(
                $params,
                ['project' => $project]
            ),
        );
    }

    #[Override]
    protected function getRequestUnderTest(): string
    {
        return GetProjectUsersRequest::class;
    }
}
