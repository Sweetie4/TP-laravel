<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Box>
 */
class BoxFactory extends Factory
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
            'owner_id'=> fake()->randomElement($userIDs),
            'img_url'=>'https://gilbert.paris/wp-content/uploads/2021/04/location-box-stockage-.jpg',
            'address'=>fake()->address(),
            'price'=> 120
        ];
    }
}
