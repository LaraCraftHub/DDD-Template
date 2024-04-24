<?php

declare(strict_types=1);

namespace Tests\Builder;

use App\Alias\SupportCollection;
use App\Domain\Project\Project;
use App\Domain\User\User;
use BadMethodCallException;
use Carbon\CarbonImmutable;
use Override;
use Tests\Builder\Stub\StubUser;

final class UserBuilder implements ModelBuilder
{
    private int $id = 1;

    private string $name = 'lggt';

    private string $email = 'test@lggt.com';

    private ?CarbonImmutable $email_verified_at = null;

    private string $password = '$2y$10$92IXUNpjO';

    private ?string $remember_token = null;

    private ?CarbonImmutable $deleted_at = null;

    private CarbonImmutable $created_at;

    private CarbonImmutable $updated_at;

    /** Relationships */

    /** @var SupportCollection<int, Project> */
    private SupportCollection $projects;

    public function __construct()
    {
        $this->created_at = CarbonImmutable::now();
        $this->updated_at = CarbonImmutable::now();

        /** Relationships */
        $this->projects = new SupportCollection([]);
    }

    #[Override]
    public function build(): User
    {
        $user = new StubUser();
        $user->setDateFormat('Y-m-d');

        $user->id = $this->id;
        $user->name = $this->name;
        $user->email = $this->email;
        $user->email_verified_at = $this->email_verified_at;
        $user->password = $this->password;
        $user->remember_token = $this->remember_token;
        $user->deleted_at = $this->deleted_at;
        $user->created_at = $this->created_at;
        $user->updated_at = $this->updated_at;

        /** Relationships */
        $user->projects = $this->projects;

        return $user;
    }

    #[Override]
    public function withId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    #[Override]
    public function withUuid(string $id): self
    {
        throw new BadMethodCallException('Project model does not use Uuids.');
    }

    public function withName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function withEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function deleted(): self
    {
        $this->deleted_at = CarbonImmutable::now();

        return $this;
    }

    public function withProject(?Project $project = null): self
    {
        $this->projects->push($project ?? (new ProjectBuilder())->build());

        return $this;
    }
}
