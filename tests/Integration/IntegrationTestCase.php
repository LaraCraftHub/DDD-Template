<?php

declare(strict_types=1);

namespace Tests\Integration;

use Database\Seeders\Testing\TestingSeeder;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Override;
use Psr\Clock\ClockInterface;
use Symfony\Component\Clock\MockClock;

abstract class IntegrationTestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    protected string $seeder = TestingSeeder::class;

    protected MockClock $clock;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->mockClock();
        // The middleware "ThrottleRequests" requires a redis connection, and we don't need it for our tests
        $this->withoutMiddleware(ThrottleRequests::class);
    }

    protected function getConfig(string $key): mixed
    {
        /** @var ConfigRepository $config */
        $config = $this->app->get(ConfigRepository::class);

        return $config->get($key);
    }

    protected function overrideConfig(string $key, mixed $value): void
    {
        /** @var ConfigRepository $config */
        $config = $this->app->get(ConfigRepository::class);
        $config->set($key, $value);
    }

    private function mockClock(): void
    {
        $this->clock = new MockClock();
        $this->instance(ClockInterface::class, $this->clock);
    }
}
