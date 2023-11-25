<?php

declare(strict_types=1);

namespace App\Domain\Project;

enum ProjectStatus: int
{
    case GENERATED = 0;
    case IN_PROGRESS = 1;
    case BLOCKED = 2;
    case TERMINATED = 3;
}
