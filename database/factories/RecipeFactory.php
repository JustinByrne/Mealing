<?php

namespace Database\Factories;

use App\Models\Recipe;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecipeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Recipe::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'servings' => $this->faker->randomDigit,
            'adults' => $this->faker->boolean,
            'kids' => $this->faker->boolean,
            'timing' => $this->faker->randomDigit,
            'user_id' => \App\Models\User::factory()->create()->id,
        ];
    }
}
