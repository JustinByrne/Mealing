<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Meal;
use App\Models\Serving;
use App\Models\Timing;
use App\Models\User;
use App\Models\Role;

class MealTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * test the index of meals.
     * 
     * @return void
     */
    public function testMealIndex()
    {
        $this->withoutExceptionHandling();

        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync([$adminId]);
        
        $response = $this->actingAs($user)->get(route('meals.index'));

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

        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync([$adminId]);

        $meal = Meal::factory()->create();

        $response = $this->actingAs($user)->get(route('meals.create', [$meal->id]));

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

        $response = $this->get(route('meals.create', [$meal->id]));

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

        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync([$adminId]);
        
        $response = $this->actingAs($user)
            ->post(route('meals.store'), [
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
     * Test create new meal with name null.
     *
     * @return void
     */
    public function testNewMealWithNameNull()
    {
        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync([$adminId]);
        
        $response = $this->actingAs($user)
            ->post(route('meals.store'), [
                'name' => null,
                'serving_id' => Serving::factory()->create()->id,
                'adults' => $this->faker->boolean,
                'kids' => $this->faker->boolean,
                'timing_id' => Timing::factory()->create()->id,
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
        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync([$adminId]);
        
        $response = $this->actingAs($user)
            ->post(route('meals.store'), [
                'name' => $this->faker->name,
                'serving_id' => null,
                'adults' => $this->faker->boolean,
                'kids' => $this->faker->boolean,
                'timing_id' => Timing::factory()->create()->id,
        ]);

        $response->assertSessionHasErrors(['serving_id']);
    }

    /**
     * Test create new meal with timing null.
     *
     * @return void
     */
    public function testNewMealWithTimingNull()
    {
        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync([$adminId]);
        
        $response = $this->actingAs($user)
            ->post(route('meals.store'), [
                'name' => $this->faker->name,
                'serving_id' => Serving::factory()->create()->id,
                'adults' => $this->faker->boolean,
                'kids' => $this->faker->boolean,
                'timing_id' => null,
        ]);

        $response->assertSessionHasErrors(['timing_id']);
    }

    /**
     * Test create new meal with adults null.
     *
     * @return void
     */
    public function testNewMealWithAdultsNull()
    {
        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync([$adminId]);
        
        $response = $this->actingAs($user)
            ->post(route('meals.store'), [
                'name' => $this->faker->name,
                'serving_id' => Serving::factory()->create()->id,
                'adults' => null,
                'kids' => $this->faker->boolean,
                'timing_id' => Timing::factory()->create()->id,
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
        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync([$adminId]);
        
        $response = $this->actingAs($user)
            ->post(route('meals.store'), [
                'name' => $this->faker->name,
                'serving_id' => Serving::factory()->create()->id,
                'adults' => $this->faker->boolean,
                'kids' => null,
                'timing_id' => Timing::factory()->create()->id,
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
                'serving_id' => Serving::factory()->create()->id,
                'adults' => $this->faker->boolean,
                'kids' => $this->faker->boolean,
                'timing_id' => Timing::factory()->create()->id,
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

        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync([$adminId]);

        $meal = Meal::factory()->create();

        $response = $this->actingAs($user)->get(route('meals.show', [$meal->id]));

        $response->assertOk();
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

        $response = $this->actingAs($user)->get(route('meals.show', [$meal->id]));

        $response->assertForbidden();
    }

    /**
     * test meal edit form.
     * 
     * @return void
     */
    public function testMealEditForm()
    {
        $this->withoutExceptionHandling();

        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync([$adminId]);

        $meal = Meal::factory()->create();

        $response = $this->actingAs($user)->get(route('meals.edit', [$meal->id]));

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

        $response = $this->get(route('meals.edit', [$meal->id]));

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

        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync([$adminId]);
        
        $meal = Meal::factory()->create();

        // new data
        $name = $this->faker->name;
        $serving = Serving::factory()->create()->id;
        $adults = $this->faker->boolean;
        $kids = $this->faker->boolean;
        $timing = Timing::factory()->create()->id;

        $response = $this->actingAs($user)
            ->patch(route('meals.update', [$meal->id]), [
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
        $serving = Serving::factory()->create()->id;
        $adults = $this->faker->boolean;
        $kids = $this->faker->boolean;
        $timing = Timing::factory()->create()->id;

        $response = $this->actingAs($user)
            ->patch(route('meals.update', [$meal->id]), [
                'name' => $name,
                'serving_id' => $serving,
                'adults' => $adults,
                'kids' => $kids,
                'timing_id' => $timing,
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

        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync([$adminId]);
        
        $meal = Meal::factory()->create();

        $this->assertDatabaseCount($meal->getTable(), 1);

        $this->actingAs($user)->delete(route('meals.destroy', [$meal->id]));

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

        $response = $this->actingAs($user)->delete(route('meals.destroy', [$meal->id]));

        $response->assertForbidden();
    }
}
