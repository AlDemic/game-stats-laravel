<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Game;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Game::class;
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'year' => $this->faker->numberBetween(1970, 2030),
            'pic' => $this->faker->sentence(128),
            'url' => $this->faker->slug,
        ];
    }
}
