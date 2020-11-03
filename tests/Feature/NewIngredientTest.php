<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Ingredient;

class NewIngredientTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    
    /**
     * test create new ingredient.
     *
     * @return void
     */
    public function testNewIngredient()
    {
        $this->withoutExceptionHandling();
        
        $response = $this->post(route('ingredient.store'), [
            'name' => $this->faker->name,
        ]);

        $ingredient = Ingredient::first();

        $this->assertDatabaseCount($ingredient->getTable(), 1);
        $response->assertRedirect($ingredient->path());
    }

    /**
     * test create new ingredient without name.
     * 
     * @return void
     */
    public function testNewIngredientWithNameNull()
    {
        $response = $this->post(route('ingredient.store'), [
            'name' => null,
        ]);

        $response->assertSessionHasErrors(['name']);
    }

    /**
     * test an ingredient can be updated
     * 
     * @return void
     */
    public function testIngredientCanBeUpdated()
    {
        $this->withoutExceptionHandling();

        $ingredient = Ingredient::factory()->create();

        // new data
        $name = $this->faker->name;

        $response = $this->patch(route('ingredient.update', [$ingredient->id]), [
            'name' => $name,
        ]);

        $this->assertEquals($name, Ingredient::first()->name);
        $response->assertRedirect($ingredient->path());
    }

    /**
     * test an ingredient can be deleted
     * 
     * @return void
     */
    public function testIngredientCanBeDeleted()
    {
        $this->withoutExceptionHandling();

        $ingredient = Ingredient::factory()->create();

        $this->assertDatabaseCount($ingredient->getTable(), 1);

        $this->delete(route('ingredient.destroy', $ingredient->id));

        $this->assertSoftDeleted($ingredient);
    }
}
