<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test',
            'email' => 'knockknock@mail.fr',
            'password' =>  Hash::make('whosthere'),
        ]);
        
        User::factory()->create([
            'name' => 'Test Bis',
            'email' => 'cesame@mail.fr',
            'password' =>  Hash::make('ouvretoi'),
        ]);
        User::factory(10)->create();
    }
}
