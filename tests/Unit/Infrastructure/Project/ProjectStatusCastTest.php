<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Project;

use App\Application\Exceptions\InvalidMixedValueException;
use App\Domain\Project\ProjectStatus;
use App\Infrastructure\Project\ProjectStatusCast;
use Illuminate\Database\Eloquent\Model;
use Override;
use Tests\Builder\ProjectBuilder;
use Tests\Unit\UnitTestCase;

final class ProjectStatusCastTest extends UnitTestCase
{
    private ProjectStatusCast $sut;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();

        $this->sut = new ProjectStatusCast();
    }

    public function test_it_throws_an_exception_fetching_a_project_status_from_an_invalid_value(): void
    {
        // Arrange
        $project = (new ProjectBuilder())->build();
        $key = 'status';
        $invalidProjectStatus = 7;
        $attributes = [];

        // Assert
        $this->expectException(InvalidMixedValueException::class);
        $this->expectExceptionMessage('Cannot fetch a ProjectStatus value from "7"');

        // Act
        $this->castValueToProjectStatus($project, $key, $invalidProjectStatus, $attributes);
    }

    public function test_it_cast_value_to_a_project_status(): void
    {
        // Arrange
        $project = (new ProjectBuilder())->build();
        $key = 'status';
        $invalidProjectStatus = 1;
        $attributes = [];

        // Act
        $result = $this->castValueToProjectStatus($project, $key, $invalidProjectStatus, $attributes);

        // Assert
        $this->assertSame(ProjectStatus::IN_PROGRESS, $result);
    }

    public function test_it_throws_an_exception_given_a_value_that_is_not_a_project_status(): void
    {
        // Arrange
        $project = (new ProjectBuilder())->build();
        $key = 'status';
        $invalidProjectStatus = 'invalid_project_status';
        $attributes = [];

        // Assert
        $this->expectException(InvalidMixedValueException::class);
        $this->expectExceptionMessage('The given value "invalid_project_status" is not a ProjectStatus');

        // Act
        $this->castProjectStatusToInteger($project, $key, $invalidProjectStatus, $attributes);
    }

    public function test_it_cast_project_status_to_an_integer_value(): void
    {
        // Arrange
        $project = (new ProjectBuilder())->build();
        $key = 'status';
        $status = ProjectStatus::TERMINATED;
        $attributes = [];

        // Act
        $result = $this->castProjectStatusToInteger($project, $key, $status, $attributes);

        // Assert
        $this->assertSame(3, $result);
    }

    /**
     * @param array<string, mixed> $attributes
     *
     * @throws InvalidMixedValueException
     */
    private function castValueToProjectStatus(Model $model, string $key, mixed $value, array $attributes): ProjectStatus
    {
        return $this->sut->get($model, $key, $value, $attributes);
    }

    /**
     * @param array<string, mixed> $attributes
     *
     * @throws InvalidMixedValueException
     */
    private function castProjectStatusToInteger(Model $model, string $key, mixed $value, array $attributes): int
    {
        return $this->sut->set($model, $key, $value, $attributes);
    }
}
