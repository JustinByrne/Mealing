<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Serving;

class NewServingTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * test create new serving.
     *
     * @return void
     */
    public function testNewServing()
    {
        $response = $this->post(route('servings.store'), [
            'quantity' => $this->faker->lexify('???'),
        ]);

        $serving = Serving::first();

        $this->assertDatabaseCount($serving->getTable(), 1);
        $response->assertRedirect($serving->path());
    }

    /**
     * test create new serving with quantity null.
     *
     * @return void
     */
    public function testNewServingWithQuantityNull()
    {
        $response = $this->post(route('servings.store'), [
            'quantity' => null,
        ]);

        $response->assertSessionHasErrors(['quantity']);
    }

    /**
     * test a serving can be updated.
     * 
     * @return void
     */
    public function testServingCanBeUpdated()
    {
        $serving = Serving::factory()->create();

        // new data
        $quantity = $this->faker->lexify('???');

        $response = $this->patch(route('servings.update', [$serving->id]), [
            'quantity' => $quantity,
        ]);

        $this->assertEquals($quantity, Serving::first()->quantity);
        $response->assertRedirect($serving->path());
    }

    /**
     * test a serving can be deleted
     * 
     * @return void
     */
    public function testServingCanBeDeleted()
    {
        $this->withoutExceptionHandling();
        
        $serving = Serving::factory()->create();

        $this->assertDatabaseCount($serving->getTable(), 1);

        $this->delete(route('servings.destroy', [$serving->id]));

        $this->assertSoftDeleted($serving);
    }
}
