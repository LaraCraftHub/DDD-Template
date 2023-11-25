<?php

declare(strict_types=1);

namespace App\Application\Providers\User;

use App\Domain\User\Repositories\UserRepository;
use App\Infrastructure\User\Repositories\EloquentUserRepository;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

final class UserServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        $this->app->singleton(UserRepository::class, EloquentUserRepository::class);
    }

    /**
     * @return array<class-string>
     */
    public function provides(): array
    {
        return [EloquentUserRepository::class];
    }
}
