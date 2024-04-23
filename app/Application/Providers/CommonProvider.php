<?php

declare(strict_types=1);

namespace App\Application\Providers;

use Override;
use App\Domain\Common\Email\EmailRenderer;
use App\Domain\Common\Event\EventDispatcher;
use App\Domain\Common\StringSluggifierInterface;
use App\Domain\Common\Time\Sleeper;
use App\Infrastructure\Common\Email\LaravelEmailRenderer;
use App\Infrastructure\Common\Event\LaravelEventDispatcher;
use App\Infrastructure\Common\StringSluggifier;
use App\Infrastructure\Common\Time\SystemSleeper;
use Illuminate\Support\ServiceProvider;
use Psr\Clock\ClockInterface;
use Symfony\Component\Clock\NativeClock;
use Symfony\Component\Uid\Factory\RandomBasedUuidFactory;
use Symfony\Component\Uid\Factory\TimeBasedUuidFactory;
use Symfony\Component\Uid\UuidV4;
use Symfony\Component\Uid\UuidV7;

final class CommonProvider extends ServiceProvider
{
    #[Override]
    public function register(): void
    {
        $this->app->bind(StringSluggifierInterface::class, StringSluggifier::class);
        $this->app->bind(EventDispatcher::class, LaravelEventDispatcher::class);
        $this->app->bind(ClockInterface::class, NativeClock::class);
        $this->app->bind(Sleeper::class, SystemSleeper::class);
        $this->app->bind(EmailRenderer::class, LaravelEmailRenderer::class);
        $this->app->bind(
            TimeBasedUuidFactory::class,
            static fn (): TimeBasedUuidFactory => new TimeBasedUuidFactory(UuidV7::class)
        );
        $this->app->bind(
            RandomBasedUuidFactory::class,
            static fn (): RandomBasedUuidFactory => new RandomBasedUuidFactory(UuidV4::class)
        );
    }
}
