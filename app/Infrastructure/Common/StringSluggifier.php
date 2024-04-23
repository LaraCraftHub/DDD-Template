<?php

declare(strict_types=1);

namespace App\Infrastructure\Common;

use Override;
use App\Domain\Common\StringSluggifierInterface;
use Illuminate\Support\Str;

final class StringSluggifier implements StringSluggifierInterface
{
    #[Override]
    public function slug(string $value): string
    {
        return Str::slug($value);
    }
}
