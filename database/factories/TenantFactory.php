<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tenant>
 */
class TenantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userIDs = User::pluck('id');
        return [
            'user_id' => fake()->randomElement($userIDs),
            'first_name'=> fake()->firstName(),
            'last_name' => fake()->lastName(),
            'phone' =>fake()->phoneNumber(),
            'email'=> fake()->unique()->safeEmail(),
            'address'=>fake()->address(),
            'bank_account'=>000000000000000
        ];
    }
}
