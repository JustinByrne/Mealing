<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Meal;
use App\Models\Role;
use App\Models\User;
use Livewire\Livewire;
use App\Http\Livewire\Comments;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MealTest extends TestCase
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
     * test the index of meals.
     * 
     * @return void
     */
    public function testCanAccessMyMealsPage()
    {
        $this->withoutExceptionHandling();
        
        $response = $this->actingAs($this->user)->get(route('meals.index'));

        $response->assertOk();
    }

    /**
     * test the all meals function.
     * 
     * @return void
     */
    public function testCanAccessAllMealsPage()
    {
        $this->withoutExceptionHandling();
        
        $response = $this->actingAs($this->user)->get(route('meals.all'));

        $response->assertOk();
    }

    /**
     * test the index of meals without permission.
     * 
     * @return void
     */
    public function testDeniedUnauthorisedAccessToMyMealsWhenNotLoggedIn()
    {
        $response = $this->get(route('meals.index'));

        $response->assertRedirect(route('login'));
    }

    /**
     * test meal create form.
     * 
     * @return void
     */
    public function testCanAccessCreateMealFormPage()
    {
        $this->withoutExceptionHandling();

        $meal = Meal::factory()->create();

        $response = $this->actingAs($this->user)->get(route('meals.create', [$meal->slug]));

        $response->assertOk();
    }

    /**
     * test meal create form without permission.
     * 
     * @return void
     */
    public function testDeniedUnauthorisedAccessToCreateMealFormWhenNotLoggedIn()
    {
        $meal = Meal::factory()->create();

        $response = $this->get(route('meals.create', [$meal->slug]));

        $response->assertRedirect(route('login'));
    }
    
    /**
     * Test create new meal.
     *
     * @return void
     */
    public function testCanCreateANewMeal()
    {
        $this->withoutExceptionHandling();
        
        $response = $this->actingAs($this->user)
            ->post(route('meals.store'), [
                'name' => $this->faker->name,
                'servings' => $this->faker->randomDigitNotNull,
                'adults' => $this->faker->boolean,
                'kids' => $this->faker->boolean,
                'timing' => $this->faker->randomDigitNotNull,
        ]);

        $meal = Meal::first();

        $this->assertDatabaseCount($meal->getTable(), 1);
        $response->assertRedirect($meal->path());
    }

    /**
     * Test create new meal with name null.
     *
     * @return void
     */
    public function testErrorWhenCreatingANewMealWithoutAName()
    {
        $response = $this->actingAs($this->user)
            ->post(route('meals.store'), [
                'name' => null,
                'servings' => $this->faker->randomDigitNotNull,
                'adults' => $this->faker->boolean,
                'kids' => $this->faker->boolean,
                'timing' => $this->faker->randomDigitNotNull,
        ]);

        $response->assertSessionHasErrors(['name']);
    }

    /**
     * Test create new meal with serving null.
     *
     * @return void
     */
    public function testErrorWhenCreatingANewMealWithoutAServing()
    {
        $response = $this->actingAs($this->user)
            ->post(route('meals.store'), [
                'name' => $this->faker->name,
                'servings' => null,
                'adults' => $this->faker->boolean,
                'kids' => $this->faker->boolean,
                'timing' => $this->faker->randomDigitNotNull,
        ]);

        $response->assertSessionHasErrors(['servings']);
    }

    /**
     * Test create new meal with timing null.
     *
     * @return void
     */
    public function testErrorWhenCreatingANewMealWithoutTiming()
    {
        $response = $this->actingAs($this->user)
            ->post(route('meals.store'), [
                'name' => $this->faker->name,
                'servings' => $this->faker->randomDigitNotNull,
                'adults' => $this->faker->boolean,
                'kids' => $this->faker->boolean,
                'timing' => null,
        ]);

        $response->assertSessionHasErrors(['timing']);
    }

    /**
     * Test create new meal without permission.
     * 
     * @return void
     */
    public function testDeniedAccessToCreateANewMealWithoutPermission()
    {
        $this->seed();
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('meals.store'), [
                'name' => $this->faker->name,
                'servings' => $this->faker->randomDigitNotNull,
                'adults' => $this->faker->boolean,
                'kids' => $this->faker->boolean,
                'timing' => $this->faker->randomDigitNotNull,
        ]);

        $response->assertForbidden();
    }

    /**
     * test a meal can be shown.
     * 
     * @return void
     */
    public function testCanAccessIndividualMealPage()
    {
        $this->withoutExceptionHandling();

        $meal = Meal::factory()->create();

        $response = $this->actingAs($this->user)->get($meal->path());

        $response->assertOk();
        $response->assertSeeLivewire('comments');
    }

    /**
     * test a meal can be shown without permission.
     * 
     * @return void
     */
    public function testDeniedAccessToViewIndividualMealWithoutPermission()
    {
        $this->seed();
        $user = User::factory()->create();

        $meal = Meal::factory()->create();

        $response = $this->actingAs($user)->get($meal->path());

        $response->assertForbidden();
    }

    /**
     * test adding a comment
     * 
     * @return void
     */
    public function testCanAddACommentToMeal()
    {
        $this->withoutExceptionHandling();

        $meal = Meal::factory()->create();
        
        Livewire::actingAs($this->user)
            ->test(Comments::class, ['meal' => $meal])
            ->set('comment', 'foo')
            ->call('addComment');
        
        $this->assertTrue(!is_null($meal->refresh()->comments->firstWhere('comment', 'foo')));
    }

    /**
     * test adding a comment with a null comment
     * 
     * @return void
     */
    public function testErrorWhenAddingACommentToMealWithoutAComment()
    {
        $meal = Meal::factory()->create();
        
        Livewire::actingAs($this->user)
            ->test(Comments::class, ['meal' => $meal])
            ->set('comment', null)
            ->call('addComment')
            ->assertHasErrors(['comment' => 'required']);
    }

    /**
     * test meal edit form.
     * 
     * @return void
     */
    public function testCanAccessEditMealFormPage()
    {
        $this->withoutExceptionHandling();

        $meal = Meal::factory()->create();

        $response = $this->actingAs($this->user)->get(route('meals.edit', [$meal->slug]));

        $response->assertOk();
    }

    /**
     * test meal edit form without permission.
     * 
     * @return void
     */
    public function testDeniedUnauthorisedAccessToEditMealFormWhenNotLoggedIn()
    {
        $meal = Meal::factory()->create();

        $response = $this->get(route('meals.edit', [$meal->slug]));

        $response->assertRedirect(route('login'));
    }

    /**
     * Test a meal can be updated.
     * 
     * @return void
     */
    public function testCanUpdateAMealsDetails()
    {
        $this->withoutExceptionHandling();
        
        $meal = Meal::factory()->create();

        // new data
        $name = $this->faker->name;
        $serving = $this->faker->randomDigitNotNull;
        $adults = $this->faker->boolean;
        $kids = $this->faker->boolean;
        $timing = $this->faker->randomDigitNotNull;

        $response = $this->actingAs($this->user)
            ->patch(route('meals.update', [$meal->slug]), [
                'name' => $name,
                'servings' => $serving,
                'adults' => $adults,
                'kids' => $kids,
                'timing' => $timing,
        ]);

        $this->assertEquals($name, Meal::first()->name);
        $this->assertEquals($serving, Meal::first()->servings);
        $this->assertEquals($adults, Meal::first()->adults);
        $this->assertEquals($kids, Meal::first()->kids);
        $this->assertEquals($timing, Meal::first()->timing);
        $response->assertRedirect(Meal::first()->path());
    }

    /**
     * Test updating meal without permission.
     * 
     * @return void
     */
    public function testDeniedAccessWhenUpdatingAMealWithoutPermission()
    {
        $this->seed();
        $user = User::factory()->create();

        $meal = Meal::factory()->create();

        // new data
        $name = $this->faker->name;
        $serving = $this->faker->randomDigitNotNull;
        $adults = $this->faker->boolean;
        $kids = $this->faker->boolean;
        $timing = $this->faker->randomDigitNotNull;

        $response = $this->actingAs($user)
            ->patch(route('meals.update', [$meal->slug]), [
                'name' => $name,
                'servings' => $serving,
                'adults' => $adults,
                'kids' => $kids,
                'timing' => $timing,
        ]);

        $response->assertForbidden();
    }

    /**
     * Test that a meal can be deleted.
     * 
     * @return void
     */
    public function testCanDeleteAMeal()
    {
        $this->withoutExceptionHandling();
        
        $meal = Meal::factory()->create();

        $this->assertDatabaseCount($meal->getTable(), 1);

        $this->actingAs($this->user)->delete(route('meals.destroy', [$meal->slug]));

        $this->assertSoftDeleted($meal);
    }

    /**
     * Test meal can be deleted without permission.
     * 
     * @return void
     */
    public function testDeniedAccessDeletingAMealWithoutPermission()
    {
        $this->seed();
        $user = User::factory()->create();
        
        $meal = Meal::factory()->create();

        $this->assertDatabaseCount($meal->getTable(), 1);

        $response = $this->actingAs($user)->delete(route('meals.destroy', [$meal->slug]));

        $response->assertForbidden();
    }
}
