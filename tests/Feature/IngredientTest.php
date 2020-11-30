<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Ingredient;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Str;

class IngredientTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * test the index of ingredients.
     * 
     * @return void
     */
    public function testIngredientIndex()
    {
        $this->withoutExceptionHandling();

        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync([$adminId]);
        
        $response = $this->actingAs($user)->get(route('ingredients.index'));

        $response->assertOk();
    }

    /**
     * test the all page for ingredients/
     * 
     * @return void
     */
    public function testIngredientAll()
    {
        $this->withoutExceptionHandling();

        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync([$adminId]);
        
        $response = $this->actingAs($user)->get(route('ingredients.all'));

        $response->assertOk();
    }

    /**
     * test the index of ingredients without permission.
     * 
     * @return void
     */
    public function testIngredientIndexWithoutPermission()
    {
        $response = $this->get(route('ingredients.index'));

        $response->assertRedirect(route('login'));
    }

    /**
     * test ingredient create form.
     * 
     * @return void
     */
    public function testIngredientCreateForm()
    {
        $this->withoutExceptionHandling();

        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync([$adminId]);

        $ingredient = Ingredient::factory()->create();

        $response = $this->actingAs($user)->get(route('ingredients.create', [$ingredient->id]));

        $response->assertOk();
    }

    /**
     * test ingredient create form without permission.
     * 
     * @return void
     */
    public function testIngredientCreateFormWithoutPermission()
    {
        $ingredient = Ingredient::factory()->create();

        $response = $this->get(route('ingredients.create', [$ingredient->id]));

        $response->assertRedirect(route('login'));
    }
    
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
     * Test create new ingredient without permission.
     * 
     * @return void
     */
    public function testNewIngredientWithoutPermission()
    {
        $this->seed();
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
            ->post(route('ingredients.store'), [
                'name' => $this->faker->name,
        ]);

        $response->assertForbidden();
    }

    /**
     * test an ingredient can be shown.
     * 
     * @return void
     */
    public function testShowingIngredient()
    {
        $this->withoutExceptionHandling();

        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync([$adminId]);

        $ingredient = Ingredient::factory()->create();

        $response = $this->actingAs($user)->get(route('ingredients.show', [$ingredient->id]));

        $response->assertOk();
    }

    /**
     * test an ingredient can be shown without permission.
     * 
     * @return void
     */
    public function testShowingIngredientWithoutPermission()
    {
        $ingredient = Ingredient::factory()->create();

        $response = $this->get(route('ingredients.show', [$ingredient->id]));

        $response->assertRedirect(route('login'));
    }

    /**
     * test ingredient edit form.
     * 
     * @return void
     */
    public function testIngredientEditForm()
    {
        $this->withoutExceptionHandling();

        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync([$adminId]);

        $ingredient = $user->ingredients()->create([
            'name' => 'cool food',
        ]);

        $response = $this->actingAs($user)->get(route('ingredients.edit', [$ingredient->id]));

        $response->assertOk();
    }

    /**
     * test ingredient edit form without permission.
     * 
     * @return void
     */
    public function testIngredientEditFormWithoutPermission()
    {
        $ingredient = Ingredient::factory()->create();

        $response = $this->get(route('ingredients.edit', [$ingredient->id]));

        $response->assertRedirect(route('login'));
    }

    /**
     * test ingredient edit form if not owner.
     * 
     * @return void
     */
    public function testIngredientEditFormNotOwner()
    {
        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync([$adminId]);
        
        $ingredient = Ingredient::factory()->create();

        $response = $this->actingAs($user)->get(route('ingredients.edit', [$ingredient->id]));

        $response->assertForbidden();
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

        $ingredient = $user->ingredients()->create([
            'name' => 'cool food',
        ]);

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
     * test an ingredient can be updated without permission
     * 
     * @return void
     */
    public function testIngredientCanBeUpdatedWithoutPermission()
    {
        $this->seed();
        $user = User::factory()->create();

        $ingredient = Ingredient::factory()->create();

        // new data
        $name = $this->faker->name;

        $response = $this->actingAs($user)
            ->patch(route('ingredients.update', [$ingredient->id]), [
                'name' => $name,
        ]);

        $response->assertForbidden();
    }

    /**
     * test an ingredient can be updated when not the owner
     * 
     * @return void
     */
    public function testIngredientCanBeUpdatedNotOwner()
    {
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

        $response->assertForbidden();
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

        $ingredient = $user->ingredients()->create([
            'name' => 'cool food',
        ]);

        $this->assertDatabaseCount($ingredient->getTable(), 1);

        $this->actingAs($user)
            ->delete(route('ingredients.destroy', $ingredient->id));

        $this->assertSoftDeleted($ingredient);
    }

    /**
     * test an ingredient can be deleted without permisison
     * 
     * @return void
     */
    public function testIngredientCanBeDeletedWithoutPermission()
    {
        $this->seed();
        $user = User::factory()->create();

        $ingredient = Ingredient::factory()->create();

        $this->assertDatabaseCount($ingredient->getTable(), 1);

        $response = $this->actingAs($user)
            ->delete(route('ingredients.destroy', $ingredient->id));

        $response->assertForbidden();
    }

    /**
     * test an ingredient can be deleted when not the owner
     * 
     * @return void
     */
    public function testIngredientCanBeDeletedNotOwner()
    {
        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync([$adminId]);

        $ingredient = Ingredient::factory()->create();

        $this->assertDatabaseCount($ingredient->getTable(), 1);

        $response = $this->actingAs($user)
            ->delete(route('ingredients.destroy', $ingredient->id));

        $response->assertForbidden();
    }
}
