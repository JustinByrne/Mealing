<?php

namespace Database\Factories;

use App\Models\Serving;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Serving::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'quantity' => $this->faker->lexify('???'),
        ];
    }
}
