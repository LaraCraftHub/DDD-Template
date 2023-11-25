<?php

declare(strict_types=1);

namespace Tests\Builder\Stub;

use App\Domain\Project\Project;
use App\Domain\User\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * Eloquent relations
 *
 * @property Collection<int, User> $users
 */
final class StubProject extends Project
{
    /** @phpstan-use StubModelOperation<User> */
    use StubModelOperation;

    public function users(): BelongsToMany
    {
        return $this->mockBelongsToMany($this->users);
    }
}
