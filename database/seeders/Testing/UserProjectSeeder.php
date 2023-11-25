<?php

declare(strict_types=1);

namespace Database\Seeders\Testing;

use App\Domain\Project\Project;
use App\Domain\User\User;
use Illuminate\Database\Seeder;

class UserProjectSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()
            ->has(Project::factory()->progressing())
            ->has(Project::factory()->progressing()->deleted())
            ->has(Project::factory()->blocked())
            ->has(Project::factory()->terminated())
            ->create();

        User::factory()
            ->unverified()
            ->create();

        User::factory()
            ->has(Project::factory()->terminated())
            ->deleted()
            ->create();
    }
}
