<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Meal;
use App\Models\Serving;
use App\Models\Timing;

class NewMealTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    
    /**
     * test create new meal.
     *
     * @return void
     */
    public function testNewMeal()
    {
        $response = $this->post('/meals', [
            'name' => $this->faker->name,
            'serving_id' => Serving::factory()->create()->id,
            'adults' => $this->faker->boolean,
            'kids' => $this->faker->boolean,
            'timing_id' => Timing::factory()->create()->id,
        ]);

        $meal = Meal::first();

        $this->assertDatabaseCount($meal->getTable(), 1);
        $response->assertRedirect($meal->path());
    }

    /**
     * test create new meal with name null.
     *
     * @return void
     */
    public function testNewMealWithNameNull()
    {
        $response = $this->post('/meals', [
            'name' => null,
            'serving_id' => Serving::factory()->create()->id,
            'adults' => $this->faker->boolean,
            'kids' => $this->faker->boolean,
            'timing_id' => Timing::factory()->create()->id,
        ]);

        $response->assertSessionHasErrors(['name']);
    }

    /**
     * test create new meal with serving null.
     *
     * @return void
     */
    public function testNewMealWithServingNull()
    {
        $response = $this->post('/meals', [
            'name' => $this->faker->name,
            'serving_id' => null,
            'adults' => $this->faker->boolean,
            'kids' => $this->faker->boolean,
            'timing_id' => Timing::factory()->create()->id,
        ]);

        $response->assertSessionHasErrors(['serving_id']);
    }

    /**
     * test create new meal with timing null.
     *
     * @return void
     */
    public function testNewMealWithTimingNull()
    {
        $response = $this->post('/meals', [
            'name' => $this->faker->name,
            'serving_id' => Serving::factory()->create()->id,
            'adults' => $this->faker->boolean,
            'kids' => $this->faker->boolean,
            'timing_id' => null,
        ]);

        $response->assertSessionHasErrors(['timing_id']);
    }

    /**
     * test create new meal with adults null.
     *
     * @return void
     */
    public function testNewMealWithAdultsNull()
    {
        $response = $this->post('/meals', [
            'name' => $this->faker->name,
            'serving_id' => Serving::factory()->create()->id,
            'adults' => null,
            'kids' => $this->faker->boolean,
            'timing_id' => Timing::factory()->create()->id,
        ]);

        $response->assertSessionHasErrors(['adults']);
    }

    /**
     * test create new meal with kids null.
     *
     * @return void
     */
    public function testNewMealWithKidsNull()
    {
        $response = $this->post('/meals', [
            'name' => $this->faker->name,
            'serving_id' => Serving::factory()->create()->id,
            'adults' => $this->faker->boolean,
            'kids' => null,
            'timing_id' => Timing::factory()->create()->id,
        ]);

        $response->assertSessionHasErrors(['kids']);
    }

    /**
     * test a meal can be updated
     * 
     * @return void
     */
    public function testMealCanBeUpdated()
    {
        $this->post('/meals', [
            'name' => $this->faker->name,
            'serving_id' => Serving::factory()->create()->id,
            'adults' => $this->faker->boolean,
            'kids' => $this->faker->boolean,
            'timing_id' => Timing::factory()->create()->id,
        ]);

        $meal = Meal::first();

        // new data
        $name = $this->faker->name;
        $serving = Serving::factory()->create()->id;
        $adults = $this->faker->boolean;
        $kids = $this->faker->boolean;
        $timing = Timing::factory()->create()->id;

        $response = $this->patch('/meals/' . $meal->id, [
            'name' => $name,
            'serving_id' => $serving,
            'adults' => $adults,
            'kids' => $kids,
            'timing_id' => $timing,
        ]);

        $this->assertEquals($name, Meal::first()->name);
        $this->assertEquals($serving, Meal::first()->serving_id);
        $this->assertEquals($adults, Meal::first()->adults);
        $this->assertEquals($kids, Meal::first()->kids);
        $this->assertEquals($timing, Meal::first()->timing_id);
        $response->assertRedirect($meal->path());
    }

    /**
     * Test that a meal can be deleted
     * 
     * @return void
     */
    public function testMealCanBeDeleted()
    {
        $this->withoutExceptionHandling();
        
        $meal = Meal::factory()->create();

        $this->assertDatabaseCount('meals', 1);

        $this->delete('/meals/' . $meal->id);

        $this->assertDeleted($meal);
    }
}
