<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Allergen;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AllergenTest extends TestCase
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
    }
    
    /**
     * test allowed access to allergens index
     * 
     * @return void
     */
    public function testCanAccessAllergenIndexPage()
    {
        $this->withoutExceptionHandling();
        $this->user->givePermissionTo('allergen_access');
        
        $response = $this->actingAs($this->user)->get(route('admin.allergens.index'));

        $response->assertOk();
        $response->assertViewIs('admin.allergens.index');
    }

    /**
     * test denied access to the index not logged in
     * 
     * @return void
     */
    public function testDeniedAccessToAllergenIndexPageWhenNotLoggedIn()
    {
        $response = $this->get(route('admin.allergens.index'));

        $this->assertGuest($guard = null);
        $response->assertRedirect(route('login'));
    }

    /**
     * test denied access to index page when user doesn't have permission
     * 
     * @return void
     */
    public function testDeniedAccessToAllergenIndexPageWithoutPermission()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->get(route('admin.allergens.index'));

        $this->assertAuthenticatedAs($user, $guard = null);
        $response->assertForbidden();
    }

    /**
     * test allowed access to allergen create page
     * 
     * @return void
     */
    public function testCanAccessAllergenCreatePage()
    {
        $this->withoutExceptionHandling();
        $this->user->givePermissionTo('allergen_create');

        $response = $this->actingAs($this->user)->get(route('admin.allergens.create'));

        $response->assertOk();
        $response->assertViewIs('admin.allergens.create');
    }

    /**
     * test denied access to allergen create page when not logged in
     * 
     * @return void
     */
    public function testDeniedAccessToAllergenCreatePageWhenNotLoggedIn()
    {
        $response = $this->get(route('admin.allergens.create'));

        $this->assertGuest($guard = null);
        $response->assertRedirect(route('login'));
    }

    /**
     * test denied access to create page when user doesn't have permission
     * 
     * @return void
     */
    public function testDeniedAccessToAllergenCreatePageWithoutPermission()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->get(route('admin.allergens.create'));

        $this->assertAuthenticatedAs($user, $guard = null);
        $response->assertForbidden();
    }

    /**
     * test can create a new allergen
     * 
     * @return void
     */
    public function testCanCreateAnAllergen()
    {
        $this->withoutExceptionHandling();
        $this->user->givePermissionTo('allergen_create');

        $data = [
            'icon' => $this->faker->word,
            'name' => $this->faker->word,
        ];

        $response = $this->actingAs($this->user)->post(route('admin.allergens.store'), $data);

        $this->assertDatabaseHas(Allergen::getTableName(), $data);
        $response->assertRedirect(route('admin.allergens.index'));
    }

    /**
     * test denied access to create an allergen when not logged in
     * 
     * @return void
     */
    public function testDeniedAccessToCreateAllergenWhenNotLoggedIn()
    {
        $data = [
            'icon' => $this->faker->word,
            'name' => $this->faker->word,
        ];

        $response = $this->post(route('admin.allergens.store'), $data);

        $this->assertDatabaseMissing(Allergen::getTableName(), $data);
        $this->assertGuest($guard = null);
        $response->assertRedirect(route('login'));
    }

    /**
     * test denied access to create an allergen without permission
     * 
     * @return void
     */
    public function testDeniedAccessToCreateAllergenWithoutPermission()
    {
        $user = User::factory()->create();

        $data = [
            'icon' => $this->faker->word,
            'name' => $this->faker->word,
        ];

        $response = $this->actingAs($user)->post(route('admin.allergens.store'), $data);

        $this->assertDatabaseMissing(Allergen::getTableName(), $data);
        $this->assertAuthenticatedAs($user, $guard = null);
        $response->assertForbidden();
    }

    /**
     * test error when creating an allergen without an icon
     * 
     * @return void
     */
    public function testErrorWhenCreatingAnAllergenWithoutAnIcon()
    {
        $this->user->givePermissionTo('allergen_create');
        
        $data = [
            'icon' => null,
            'name' => $this->faker->word,
        ];

        $response = $this->actingAs($this->user)->post(route('admin.allergens.store'), $data);

        $this->assertDatabaseMissing(Allergen::getTableName(), $data);
        $response->assertSessionHasErrors(['icon']);
    }

    /**
     * test error when creating an allergen without a name
     * 
     * @return void
     */
    public function testErrorWhenCreatingAnAllergenWithoutAName()
    {
        $this->user->givePermissionTo('allergen_create');
        
        $data = [
            'icon' => $this->faker->word,
            'name' => null
        ];

        $response = $this->actingAs($this->user)->post(route('admin.allergens.store'), $data);

        $this->assertDatabaseMissing(Allergen::getTableName(), $data);
        $response->assertSessionHasErrors(['name']);
    }

    /**
     * test can access edit page
     * 
     * @return void
     */
    public function testCanAccessAllergenEditPage()
    {
        $this->withoutExceptionHandling();
        $this->user->givePermissionTo('allergen_edit');
        $allergen = Allergen::factory()->create();
        
        $response = $this->actingAs($this->user)->get(route('admin.allergens.edit', [$allergen]));

        $response->assertOk();
        $response->assertViewIs('admin.allergens.edit');
    }

    /**
     * test denied access to edit page when not logged in
     * 
     * @return void
     */
    public function testDeniedAccessToAllergenEditPageWhenNotLoggedIn()
    {
        $allergen = Allergen::factory()->create();
        
        $response = $this->get(route('admin.allergens.edit', [$allergen]));
        
        $this->assertGuest($guard = null);
        $response->assertRedirect(route('login'));
    }

    /**
     * test denied access to edit page without permission
     * 
     * @return void
     */
    public function testDeniedAccessToAllergenEditPageWithoutPermission()
    {
        $user = User::factory()->create();
        $allergen = Allergen::factory()->create();
        
        $response = $this->actingAs($user)->get(route('admin.allergens.edit', [$allergen]));

        $this->assertAuthenticatedAs($user, $guard = null);
        $response->assertForbidden();
    }

    /**
     * test a allergen can be updated
     * 
     * @return void
     */
    public function testCanEditAnAllergen()
    {
        $this->user->givePermissionTo('allergen_edit');
        $allergen = Allergen::factory()->create();
        $data = [
            'icon' => $this->faker->word,
            'name' => $this->faker->word,
        ];
        
        $response = $this->actingAs($this->user)->patch(route('admin.allergens.update', [$allergen]), $data);

        $this->assertDatabaseHas(Allergen::getTableName(), $data);
        $response->assertRedirect(route('admin.allergens.index'));
    }

    /**
     * test denied access to update an allergen when not logged in
     * 
     * @return void
     */
    public function testDeniedAccessToUpdateAnAllergenWhenNotLoggedIn()
    {
        $allergen = Allergen::factory()->create();
        $data = [
            'icon' => $this->faker->word,
            'name' => $this->faker->word,
        ];
        
        $response = $this->patch(route('admin.allergens.update', [$allergen]), $data);
        
        $this->assertGuest($guard = null);
        $response->assertRedirect(route('login'));
    }

    /**
     * test denied access to update an allergen without permisison
     * 
     * @return void
     */
    public function testDeniedAccessToUpdateAnAllergenWithoutPermission()
    {
        $user = User::factory()->create();
        $allergen = Allergen::factory()->create();
        $data = [
            'icon' => $this->faker->word,
            'name' => $this->faker->word,
        ];
        
        $response = $this->actingAs($user)->patch(route('admin.allergens.update', [$allergen]), $data);

        $this->assertAuthenticatedAs($user, $guard = null);
        $response->assertForbidden();
    }

    /**
     * test session has an error when updating an allergen without a name
     * 
     * @return void
     */
    public function testErrorWhenUpdatingAnAllergenWithoutAName()
    {
        $this->user->givePermissionTo('allergen_edit');
        $allergen = Allergen::factory()->create();
        $data = [
            'icon' => $this->faker->word,
            'name' => null
        ];

        $response = $this->actingAs($this->user)->patch(route('admin.allergens.update', [$allergen]), $data);

        $this->assertDatabaseMissing(Allergen::getTableName(), $data);
        $response->assertSessionHasErrors(['name']);
    }

    /**
     * test session has an error when updating an allergen without an icon
     * 
     * @return void
     */
    public function testErrorWhenUpdatingAnAllergenWithoutAnIcon()
    {
        $this->user->givePermissionTo('allergen_edit');
        $allergen = Allergen::factory()->create();
        $data = [
            'icon' => null,
            'name' => $this->faker->word,
        ];

        $response = $this->actingAs($this->user)->patch(route('admin.allergens.update', [$allergen]), $data);

        $this->assertDatabaseMissing(Allergen::getTableName(), $data);
        $response->assertSessionHasErrors(['icon']);
    }

    /**
     * test an allergen can be deleted
     * 
     * @return void
     */
    public function testCanDeleteAnAllergen()
    {
        $this->user->givePermissionTo('allergen_delete');
        $allergen = Allergen::factory()->create();
        
        $response = $this->actingAs($this->user)->delete(route('admin.allergens.destroy', [$allergen]));

        $this->assertDatabaseMissing(Allergen::getTableName(), $allergen->toArray());
        $response->assertRedirect(route('admin.allergens.index'));
    }

    /**
     * test denied access to delete an allergen when not logged in
     * 
     * @return void
     */
    public function testDeniedDeletingAnAllergenWhenNotLoggedIn()
    {
        $allergen = Allergen::factory()->create();
        
        $response = $this->delete(route('admin.allergens.destroy', [$allergen]));
        
        $this->assertGuest($guard = null);
        $response->assertRedirect(route('login'));
    }

    /**
     * test denied access to delete an allergen without permission
     * 
     * @return void
     */
    public function testDeniedDeletingAnAllergenWithoutPermission()
    {
        $user = User::factory()->create();
        $allergen = Allergen::factory()->create();
        
        $response = $this->actingAs($user)->delete(route('admin.allergens.destroy', [$allergen]));

        $this->assertAuthenticatedAs($user, $guard = null);
        $response->assertForbidden();
    }
}