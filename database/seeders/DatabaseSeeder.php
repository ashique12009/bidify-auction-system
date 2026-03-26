<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserRoleSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserRoleSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}
