<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Domain\Project\Project;
use App\Domain\Project\ProjectStatus;
use DateTimeImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    protected $model = Project::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->title(),
            'status' => ProjectStatus::GENERATED,
            'funds' => 15678.256,
            'started_at' => null,
            'blocked_at' => null,
            'terminated_at' => null,
            'deleted_at' => null,
        ];
    }

    public function progressing(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => ProjectStatus::IN_PROGRESS,
            'started_at' => new DateTimeImmutable(),
        ]);
    }

    public function blocked(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => ProjectStatus::BLOCKED,
            'blocked_at' => new DateTimeImmutable(),
        ]);
    }

    public function terminated(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => ProjectStatus::TERMINATED,
            'terminated_at' => new DateTimeImmutable(),
        ]);
    }

    public function deleted(): static
    {
        return $this->state(fn (array $attributes) => [
            'deleted_at' => new DateTimeImmutable(),
        ]);
    }
}
