<?php

namespace Database\Seeders;

use App\Models\ModelContract;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            BoxSeeder::class,
            TenantSeeder::class,
            ModelContractSeeder::class
        ]);
    }
}
