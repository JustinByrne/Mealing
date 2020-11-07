<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Ingredient;
use App\Models\User;
use App\Models\Role;

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

        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync([$adminId]);
        
        $response = $this->actingAs($user)
            ->post(route('ingredients.store'), [
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
        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync([$adminId]);
        
        $response = $this->actingAs($user)
            ->post(route('ingredients.store'), [
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

        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync([$adminId]);

        $ingredient = Ingredient::factory()->create();

        // new data
        $name = $this->faker->name;

        $response = $this->actingAs($user)
            ->patch(route('ingredients.update', [$ingredient->id]), [
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

        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync([$adminId]);

        $ingredient = Ingredient::factory()->create();

        $this->assertDatabaseCount($ingredient->getTable(), 1);

        $this->actingAs($user)
            ->delete(route('ingredients.destroy', $ingredient->id));

        $this->assertSoftDeleted($ingredient);
    }
}
