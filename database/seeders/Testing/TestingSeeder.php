<?php

declare(strict_types=1);

namespace Database\Seeders\Testing;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestingSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            UserProjectSeeder::class,
        ]);
    }
}
