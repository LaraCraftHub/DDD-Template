<?php

declare(strict_types=1);

namespace App\Domain\Common;

interface StringSluggifierInterface
{
    public function slug(string $value): string;
}
