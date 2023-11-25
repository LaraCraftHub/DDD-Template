<?php

declare(strict_types=1);

namespace Tests\Builder;

use App\Domain\Project\Project;
use App\Domain\Project\ProjectStatus;
use App\Domain\User\User;
use BadMethodCallException;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Tests\Builder\Stub\StubProject;

final class ProjectBuilder implements ModelBuilder
{
    private int $id = 1;

    private string $title = 'project_sample';

    private ProjectStatus $status = ProjectStatus::GENERATED;

    private float $funds = 23656.67;

    private ?CarbonImmutable $started_at = null;

    private ?CarbonImmutable $blocked_at = null;

    private ?CarbonImmutable $terminated_at = null;

    private ?CarbonImmutable $deleted_at = null;

    private CarbonImmutable $created_at;

    private CarbonImmutable $updated_at;

    /** Relationships */

    /** @var Collection<int, User> */
    private Collection $users;

    public function __construct()
    {
        $this->created_at = CarbonImmutable::now();
        $this->updated_at = CarbonImmutable::now();

        /** Relationships */
        $this->users = new Collection([]);
    }

    public function build(): Project
    {
        $project = new StubProject();
        $project->setDateFormat('Y-m-d');

        $project->id = $this->id;
        $project->title = $this->title;
        $project->status = $this->status;
        $project->funds = $this->funds;
        $project->started_at = $this->started_at;
        $project->blocked_at = $this->blocked_at;
        $project->terminated_at = $this->terminated_at;
        $project->deleted_at = $this->deleted_at;
        $project->created_at = $this->created_at;
        $project->updated_at = $this->updated_at;

        /** Relationships */
        $project->users = $this->users;

        return $project;
    }

    public function withId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function withUuid(string $id): self
    {
        throw new BadMethodCallException('Project model does not use Uuids.');
    }

    public function withTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function withFunds(float $funds): self
    {
        $this->funds = $funds;

        return $this;
    }

    public function withInProgressStatus(): self
    {
        $this->status = ProjectStatus::IN_PROGRESS;
        $this->started_at = CarbonImmutable::now();

        return $this;
    }

    public function withBlockedStatus(): self
    {
        $this->status = ProjectStatus::BLOCKED;
        $this->blocked_at = CarbonImmutable::now();

        return $this;
    }

    public function withTerminatedStatus(): self
    {
        $this->status = ProjectStatus::TERMINATED;
        $this->terminated_at = CarbonImmutable::now();

        return $this;
    }

    public function deleted(): self
    {
        $this->deleted_at = CarbonImmutable::now();

        return $this;
    }

    public function withUser(User $user = null): self
    {
        $this->users->push($user ?? (new UserBuilder())->build());

        return $this;
    }
}
