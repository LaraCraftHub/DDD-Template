<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Http\Requests\Project;

use App\Application\Http\Requests\Project\GetUserProjectsRequest;
use App\Domain\Project\ProjectStatus;
use Tests\Builder\UserBuilder;
use Tests\Unit\Application\Http\Requests\Helpers\StubRepository;
use Tests\Unit\Application\Http\Requests\RequestTestCase;

final class GetUserProjectsRequestTest extends RequestTestCase
{
    public function test_it_does_not_validate_request_when_group_by_status_param_is_not_provided(): void
    {
        // Arrange
        $params = [];

        // Act && Assert
        $this->assertFalse($this->validateParameters($params));
    }

    public function test_it_does_not_validate_request_when_user_does_not_exist(): void
    {
        // Arrange
        $params = [
            'group_by_status' => true,
            'user_id' => 444,
        ];

        // Act && Assert
        $this->assertFalse($this->validateParameters($params));
    }

    public function test_it_does_not_validate_request_when_project_status_is_invalid(): void
    {
        // Arrange
        $params = [
            'group_by_status' => true,
            'status' => 444,
        ];

        // Act && Assert
        $this->assertFalse($this->validateParameters($params));
    }

    public function test_it_validates_request_when_all_params_are_valid(): void
    {
        // Arrange
        $user = (new UserBuilder())->withId(444)->build();
        StubRepository::addToRepository($user);

        $params = [
            'group_by_status' => true,
            'user_id' => $user->id,
            'status' => ProjectStatus::TERMINATED,
        ];

        // Act && Assert
        $this->assertTrue($this->validateParameters($params));
    }

    protected function getRequestUnderTest(): string
    {
        return GetUserProjectsRequest::class;
    }
}
