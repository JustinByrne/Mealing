<?php

namespace Database\Factories;

use App\Models\Meal;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Serving;
use App\Models\Timing;

class MealFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Meal::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'serving_id' => Serving::factory()->create(),
            'adults' => $this->faker->boolean,
            'kids' => $this->faker->boolean,
            'timing_id' => Timing::factory()->create(),
        ];
    }
}
