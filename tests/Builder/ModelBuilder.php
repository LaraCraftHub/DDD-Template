<?php

declare(strict_types=1);

namespace Tests\Builder;

use BadMethodCallException;
use Illuminate\Database\Eloquent\Model;

interface ModelBuilder
{
    public function build(): Model;

    /**
     * @throws BadMethodCallException
     */
    public function withId(int $id): self;

    /**
     * @throws BadMethodCallException
     */
    public function withUuid(string $id): self;
}
