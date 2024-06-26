<?php

declare(strict_types=1);

namespace Tests\Builder\Stub;

use App\Alias\SupportCollection;
use App\Domain\Project\Project;
use App\Domain\User\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\DatabaseNotification as DbNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Override;

/**
 * Eloquent relations
 *
 * @property DatabaseNotificationCollection<int, DbNotification> $notifications
 * @property SupportCollection<int, Project> $projects
 */
final class StubUser extends User
{
    /** @phpstan-use StubModelOperation<Project> */
    use StubModelOperation;

    #[Override]
    public function projects(): BelongsToMany
    {
        return $this->mockBelongsToMany($this->projects);
    }
}
