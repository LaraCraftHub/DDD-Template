<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Http\Requests\Helpers;

use Closure;
use Illuminate\Container\Container;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Validation\Validator;
use Override;

final class StubValidationFactory implements Factory
{
    /**
     * @param string $rule
     * @param Closure|string $extension
     * @param string|null $message
     */
    #[Override]
    public function extend($rule, $extension, $message = null): void
    {
    }

    /**
     * @param string $rule
     * @param Closure|string $extension
     * @param string|null $message
     */
    #[Override]
    public function extendImplicit($rule, $extension, $message = null): void
    {
    }

    /**
     * @param array<string, mixed> $data
     * @param array<string, string> $rules
     * @param array<string, string> $messages
     * @param array<string, string> $attributes
     */
    #[Override]
    public function make(array $data, array $rules, array $messages = [], array $attributes = []): Validator
    {
        $translator = new StubTranslator();

        $container = new Container();
        $container->offsetSet(Translator::class, $translator);
        $container->offsetSet('translator', $translator);

        Container::setInstance($container);

        $stubValidator = new StubValidator($data, $rules);
        $stubValidator->setContainer($container);
        $stubValidator->addExtensions($this->customExtensions());

        return $stubValidator;
    }

    /**
     * @param string $rule
     * @param Closure|string $replacer
     */
    #[Override]
    public function replacer($rule, $replacer): void
    {
    }

    /**
     * @return array<string, string>
     */
    private function customExtensions(): array
    {
        return [
            // e.g. : 'rgbColor' => RGBColorRule::class . '@passes',
        ];
    }
}
