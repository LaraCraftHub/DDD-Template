<?php

declare(strict_types=1);

namespace Tests\Integration;

use Database\Seeders\Testing\TestingSeeder;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Override;

abstract class IntegrationTestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    protected string $seeder = TestingSeeder::class;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        // The middleware "ThrottleRequests" requires a redis connection, and we don't need it for our tests
        $this->withoutMiddleware(ThrottleRequests::class);
    }

    #[Override]
    public function createApplication()
    {
        $app = require __DIR__ . '/../../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }
}
