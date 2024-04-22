<?php

declare(strict_types=1);

namespace Tests\Unit;

use Illuminate\Container\Container;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Contracts\Config\Repository as ConfigContract;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Hashing\HashManager;
use Illuminate\Support\Facades\Facade;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use Override;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Fakes\FakeLog;

abstract class UnitTestCase extends TestCase
{
    use MockeryPHPUnitIntegration;

    protected Container $contract;

    protected ConfigContract&MockInterface $configMock;

    protected Dispatcher&MockInterface $dispatcherMock;

    /**
     * @throws BindingResolutionException
     */
    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        // Create an empty container.
        $container = new Container();
        // Put a fake logger implementation into the container
        $container->singleton('log', FakeLog::class);
        // Bind the Application facade to the Container
        $container->singleton('app', static fn (): Container => $container);
        // Bind the Hash facade to the Container
        $container->singleton('hash', static fn (): HashManager => new HashManager($container));
        // Bind the Application interface to the Container
        $container->singleton(Application::class, static fn (): Container => $container);
        // Put the config mock instance into the container
        $this->mockConfig($container);
        // Put the dispatcher mock instance into the container
        $this->mockDispatcher($container);
        // Set the container as unique instance.
        Container::setInstance($container);
        // Resolve an instance of Application from the Container
        $app = $container->make(Application::class);
        // Set the container into the facade.
        Facade::setFacadeApplication($app);
    }

    #[Override]
    protected function tearDown(): void
    {
        parent::tearDown();
        // Remove all cached service instances.
        Facade::clearResolvedInstances();
        // Remove the container instance from the Facade.
        Facade::setFacadeApplication(null);
        // Remove the container instance singleton.
        Container::setInstance(null);
        Mockery::close();
    }

    private function mockConfig(Container $container): void
    {
        $this->configMock = Mockery::mock(ConfigContract::class);
        $this->mockHash($this->configMock);
        $container->instance('config', $this->configMock);
    }

    private function mockDispatcher(Container $container): void
    {
        $this->dispatcherMock = Mockery::mock(Dispatcher::class);
        $container->instance(Dispatcher::class, $this->dispatcherMock);
    }

    private function mockHash(MockInterface $configMock): void
    {
        $configMock
            ->shouldReceive('get')
            ->with('hashing.driver', 'bcrypt')
            ->andReturn('bcrypt');
        $configMock
            ->shouldReceive('get')
            ->with('hashing.bcrypt')
            ->andReturn([
                'rounds' => 12,
                'verify' => true,
            ]);
    }
}
