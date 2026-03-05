<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Online;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Online>
 */
class OnlineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Online::class;
    public function definition(): array
    {
        return [
            'game_id' => $this->faker->randomDigitNotNull,
            'date' => $this->faker->date,
            'stat' => $this->faker->randomDigitNotNull,
            'source' => $this->faker->sentence(128)
        ];
    }
}
