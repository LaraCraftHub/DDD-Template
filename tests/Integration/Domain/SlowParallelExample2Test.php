<?php

declare(strict_types=1);

namespace Tests\Integration\Domain;

use Tests\Integration\IntegrationTestCase;

final class SlowParallelExample2Test extends IntegrationTestCase
{
    public function test_true_is_true(): void
    {
        sleep(20);
        // @phpstan-ignore-next-line
        $this->assertTrue(true);
    }
}
