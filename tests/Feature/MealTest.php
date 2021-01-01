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
    public function testMealIndex()
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
    public function testMealAll()
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
    public function testMealIndexWithoutPermission()
    {
        $response = $this->get(route('meals.index'));

        $response->assertRedirect(route('login'));
    }

    /**
     * test meal create form.
     * 
     * @return void
     */
    public function testMealCreateForm()
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
    public function testMealCreateFormWithoutPermission()
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
    public function testNewMeal()
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
    public function testNewMealWithNameNull()
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
    public function testNewMealWithServingNull()
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
    public function testNewMealWithTimingNull()
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
     * Test create new meal with adults null.
     *
     * @return void
     */
    public function testNewMealWithAdultsNull()
    {
        $response = $this->actingAs($this->user)
            ->post(route('meals.store'), [
                'name' => $this->faker->name,
                'servings' => $this->faker->randomDigitNotNull,
                'adults' => null,
                'kids' => $this->faker->boolean,
                'timing' => $this->faker->randomDigitNotNull,
        ]);

        $response->assertSessionHasErrors(['adults']);
    }

    /**
     * Test create new meal with kids null.
     *
     * @return void
     */
    public function testNewMealWithKidsNull()
    {
        $response = $this->actingAs($this->user)
            ->post(route('meals.store'), [
                'name' => $this->faker->name,
                'servings' => $this->faker->randomDigitNotNull,
                'adults' => $this->faker->boolean,
                'kids' => null,
                'timing' => $this->faker->randomDigitNotNull,
        ]);

        $response->assertSessionHasErrors(['kids']);
    }

    /**
     * Test create new meal without permission.
     * 
     * @return void
     */
    public function testNewMealWithoutAccess()
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
    public function testShowingMeal()
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
    public function testShowingMealWithoutPermission()
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
    public function testAddingCommentToMeal()
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
    public function testAddingCommentToMealWithCommentNull()
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
    public function testMealEditForm()
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
    public function testMealEditFormWithoutPermission()
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
    public function testMealCanBeUpdated()
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
    public function testCanBeUpdatedWithoutPermission()
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
    public function testMealCanBeDeleted()
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
    public function testMealCanBeDeletedWithoutPermission()
    {
        $this->seed();
        $user = User::factory()->create();
        
        $meal = Meal::factory()->create();

        $this->assertDatabaseCount($meal->getTable(), 1);

        $response = $this->actingAs($user)->delete(route('meals.destroy', [$meal->slug]));

        $response->assertForbidden();
    }
}
