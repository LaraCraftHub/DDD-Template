<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Http\Requests\Helpers;

use Countable;
use Illuminate\Contracts\Translation\Translator;
use Override;

final class StubTranslator implements Translator
{
    /**
     * @param string $key
     * @param Countable|int|array<int|string, int> $number
     * @param array<string, mixed> $replace
     * @param string|null $locale
     */
    #[Override]
    public function choice($key, $number, array $replace = [], $locale = null): string
    {
        return $key;
    }

    /**
     * @param string $key
     * @param array<string, mixed> $replace
     * @param null $locale
     */
    #[Override]
    public function get($key, array $replace = [], $locale = null): string
    {
        return $key;
    }

    #[Override]
    public function getLocale(): string
    {
        return 'en';
    }

    /**
     * @param string $locale
     */
    #[Override]
    public function setLocale($locale): void
    {
    }
}
