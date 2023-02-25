<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Genre;
use App\Models\Movie;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    protected $model = Movie::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'genre_id'=>Genre::factory(),
            'user_id'=>User::factory(),
            'name'=>$this->faker->word(),
            'duration'=>$this->faker->numberBetween(90,120),
            'director'=>$this->faker->word(),
            'box_office'=>$this->faker->boolean()
        ];
    }
}
