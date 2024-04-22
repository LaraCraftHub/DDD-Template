<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Http\Requests;

use Exception;
use Illuminate\Container\Container;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\Route;
use Illuminate\Routing\RouteCollection;
use Illuminate\Routing\UrlGenerator;
use Override;
use Tests\Unit\Application\Http\Requests\Helpers\StubRepository;
use Tests\Unit\Application\Http\Requests\Helpers\StubValidationFactory;
use Tests\Unit\UnitTestCase;

abstract class RequestTestCase extends UnitTestCase
{
    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        StubRepository::clearRepository();
    }

    /**
     * @param array<string, mixed> $requestParameters
     */
    public function validateParameters(array $requestParameters): bool
    {
        try {
            $this->createRequest($requestParameters)->validateResolved();
        } catch (Exception) {
            return false;
        }

        return true;
    }

    /**
     * @param array<string, mixed> $requestParameters
     * @param array<string, mixed> $routeParameters
     */
    public function validateWithRouteParameters(array $requestParameters, array $routeParameters): bool
    {
        try {
            $formRequest = $this->createRequest($requestParameters);
            $this->setRequestRouteParameters($formRequest, $routeParameters);
            $formRequest->validateResolved();
        } catch (Exception) {
            return false;
        }

        return true;
    }

    abstract protected function getRequestUnderTest(): string;

    private function createContainer(): Container
    {
        $container = new Container();
        $container->bindMethod($this->getRequestUnderTest() . '@authorize', static fn (): bool => true);
        $container->bind(ValidationFactory::class, StubValidationFactory::class);

        return $container;
    }

    /**
     * @param array<string, mixed> $requestParameters
     */
    private function createRequest(array $requestParameters): FormRequest
    {
        $requestUnderTestClass = $this->getRequestUnderTest();
        /** @var FormRequest $request */
        $request = new $requestUnderTestClass($requestParameters);
        $request->setContainer($this->createContainer());
        $request->setRedirector(new Redirector(new UrlGenerator(new RouteCollection(), new Request())));

        return $request;
    }

    /**
     * @param array<string, mixed> $routeParameters
     */
    private function setRequestRouteParameters(FormRequest $formRequest, array $routeParameters): void
    {
        $formRequest->setRouteResolver(static function () use ($formRequest, $routeParameters): Route {
            $route = new Route('', '', []);
            $route->bind($formRequest);
            foreach ($routeParameters as $parameterName => $parameterValue) {
                $route->setParameter($parameterName, $parameterValue);
            }

            return $route;
        });
    }
}
