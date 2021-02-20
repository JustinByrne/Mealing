<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use Livewire\Livewire;
use App\Models\Ingredient;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IngredientTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public $user;

    /**
     * setting up a user to be used in all tests
     * 
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
        $this->user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $this->user->roles()->sync([$adminId]);
    }

    /**
     * test the index of ingredients.
     * 
     * @return void
     */
    public function testCanAccessTheMyIngredientsPage()
    {
        $this->withoutExceptionHandling();
        
        $response = $this->actingAs($this->user)->get(route('ingredients.index'));

        $response->assertOk();
    }

    /**
     * test the all page for ingredients/
     * 
     * @return void
     */
    public function testCanAccessTheAllIngredientsPage()
    {
        $this->withoutExceptionHandling();
        
        $response = $this->actingAs($this->user)->get(route('ingredients.all'));

        $response->assertOk();
    }

    /**
     * test the index of ingredients without permission.
     * 
     * @return void
     */
    public function testUnathorisedAccessToIngredientIndexWhenNotLoggedIn()
    {
        $response = $this->get(route('ingredients.index'));

        $response->assertRedirect(route('login'));
    }

    /**
     * test ingredient create form.
     * 
     * @return void
     */
    public function testCanAccessIngredientCreateForm()
    {
        $this->withoutExceptionHandling();

        $ingredient = Ingredient::factory()->create();

        $response = $this->actingAs($this->user)->get(route('ingredients.create', [$ingredient->slug]));

        $response->assertOk();
    }

    /**
     * test ingredient create form without permission.
     * 
     * @return void
     */
    public function testUnauthorisedAccessToIngredientCreateFormWhenNotLoggedIn()
    {
        $ingredient = Ingredient::factory()->create();

        $response = $this->get(route('ingredients.create', [$ingredient->slug]));

        $response->assertRedirect(route('login'));
    }
    
    /**
     * test create new ingredient.
     *
     * @return void
     */
    public function testCanCreateANewIngredient()
    {
        $this->withoutExceptionHandling();

        $data = [
            'name' => $this->faker->name,
        ];
        
        $response = $this->actingAs($this->user)->post(route('ingredients.store'), $data);

        $ingredient = Ingredient::first();

        $this->assertDatabaseCount(Ingredient::getTableName(), 1);
        $this->assertDatabaseHas(Ingredient::getTableName(), $data);
        $response->assertRedirect($ingredient->path());
    }

    /**
     * test create new ingredient without name.
     * 
     * @return void
     */
    public function testErrorWhenCreatingANewIngredientWithoutName()
    {
        $data = [
            'name' => null,
        ];
        
        $response = $this->actingAs($this->user)->post(route('ingredients.store'), $data);

        $this->assertDatabaseMissing(Ingredient::getTableName(), $data);
        $response->assertSessionHasErrors(['name']);
    }

    /**
     * Test create new ingredient without permission.
     * 
     * @return void
     */
    public function testDeniedAccessToCreateANewIngredientWithoutPermission()
    {
        $user = User::factory()->create();

        $data = [
            'name' => $this->faker->name,
        ];
        
        $response = $this->actingAs($user)->post(route('ingredients.store'), $data);

        $response->assertForbidden();
    }

    /**
     * test an ingredient can be shown.
     * 
     * @return void
     */
    public function testCanAccessAnIngredientPage()
    {
        $this->withoutExceptionHandling();

        $ingredient = Ingredient::factory()->create();

        $response = $this->actingAs($this->user)->get(route('ingredients.show', [$ingredient->slug]));

        $response->assertOk();
        $response->assertSee($ingredient->name);
    }

    /**
     * test an ingredient can be shown without permission.
     * 
     * @return void
     */
    public function testDeniedAccessToShowingIngredientWithoutPermission()
    {
        $ingredient = Ingredient::factory()->create();

        $response = $this->get(route('ingredients.show', [$ingredient->slug]));

        $response->assertRedirect(route('login'));
    }

    /**
     * test ingredient edit form.
     * 
     * @return void
     */
    public function testCanAccessTheIngredientEditForm()
    {
        $this->withoutExceptionHandling();

        $ingredient = Ingredient::factory()->for($this->user)->create();

        $response = $this->actingAs($this->user)->get(route('ingredients.edit', [$ingredient->slug]));

        $response->assertOk();
    }

    /**
     * test ingredient edit form without permission.
     * 
     * @return void
     */
    public function testDeniedAccessToIngredientEditFormWithoutPermission()
    {
        $ingredient = Ingredient::factory()->for($this->user)->create();

        $response = $this->get(route('ingredients.edit', [$ingredient->slug]));

        $response->assertRedirect(route('login'));
    }

    /**
     * test ingredient edit form if not owner.
     * 
     * @return void
     */
    public function testDeniedAccessToEditTheIngredientWhenNotTheOwner()
    {
        $ingredient = Ingredient::factory()->create();

        $response = $this->actingAs($this->user)->get(route('ingredients.edit', [$ingredient->slug]));

        $response->assertForbidden();
    }

    /**
     * test an ingredient can be updated
     * 
     * @return void
     */
    public function testAnIngredientCanBeUpdated()
    {
        $this->withoutExceptionHandling();

        $ingredient = Ingredient::factory()->for($this->user)->create();

        $data = [
            'name' => $this->faker->name
        ];

        $response = $this->actingAs($this->user)->patch(route('ingredients.update', [$ingredient->slug]), $data);

        $this->assertDatabaseHas(Ingredient::getTableName(), $data);
        $response->assertRedirect(Ingredient::first()->path());
    }

    /**
     * test an ingredient can be updated without permission
     * 
     * @return void
     */
    public function testDeniedAccessToIngredientCanBeUpdatedWithoutPermission()
    {
        $user = User::factory()->create();

        $ingredient = Ingredient::factory()->for($user)->create();

        $data = [
            'name' => $this->faker->name
        ];

        $response = $this->actingAs($user)->patch(route('ingredients.update', [$ingredient->slug]), $data);

        $response->assertForbidden();
    }

    /**
     * test an ingredient can be updated when not the owner
     * 
     * @return void
     */
    public function testDeniedAccessToUpdateIngredientWhenNotTheOwner()
    {
        $ingredient = Ingredient::factory()->create();

        // new data
        $data = [
            'name' => $this->faker->name
        ];

        $response = $this->actingAs($this->user)->patch(route('ingredients.update', [$ingredient->slug]), $data);

        $response->assertForbidden();
    }

    /**
     * test an ingredient can be deleted
     * 
     * @return void
     */
    public function testAnIngredientCanBeDeleted()
    {
        $this->withoutExceptionHandling();

        $ingredient = Ingredient::factory()->for($this->user)->create();

        $this->assertDatabaseCount(Ingredient::getTableName(), 1);

        $this->actingAs($this->user)->delete(route('ingredients.destroy', $ingredient->slug));

        $this->assertSoftDeleted($ingredient);
    }

    /**
     * test an ingredient can be deleted without permisison
     * 
     * @return void
     */
    public function testDeniedAccessToIngredientCanBeDeletedWithoutPermission()
    {
        $user = User::factory()->create();

        $ingredient = Ingredient::factory()->for($user)->create();

        $this->assertDatabaseCount(Ingredient::getTableName(), 1);

        $response = $this->actingAs($user)->delete(route('ingredients.destroy', $ingredient->slug));

        $response->assertForbidden();
    }

    /**
     * test an ingredient can be deleted when not the owner
     * 
     * @return void
     */
    public function testDeniedAccessToDeleteIngredientWhenNotTheOwner()
    {
        $ingredient = Ingredient::factory()->create();

        $this->assertDatabaseCount(Ingredient::getTableName(), 1);

        $response = $this->actingAs($this->user)->delete(route('ingredients.destroy', $ingredient->slug));

        $response->assertForbidden();
    }

    /**
     * test creating ingredient from livewire
     * 
     * @return void
     */
    public function testCanCreateANewIngredientWithLivewire()
    {
        Livewire::actingAs($this->user)
                    ->test('meals.create')
                    ->set('query', 'foo')
                    ->call('createIngredient');
        
        $this->assertDatabaseHas(Ingredient::getTableName(), ['name' => 'foo']);
    }
}
