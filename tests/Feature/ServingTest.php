<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Serving;
use App\Models\User;
use App\Models\Role;

class ServingTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * test the index of servings.
     * 
     * @return void
     */
    public function testServingIndex()
    {
        $this->withoutExceptionHandling();

        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync([$adminId]);
        
        $response = $this->actingAs($user)->get(route('servings.index'));

        $response->assertOk();
    }

    /**
     * test the index of servings without permission.
     * 
     * @return void
     */
    public function testServingIndexWithoutPermission()
    {
        $response = $this->get(route('servings.index'));

        $response->assertStatus(403);
    }

    /**
     * test serving create form.
     * 
     * @return void
     */
    public function testServingCreateForm()
    {
        $this->withoutExceptionHandling();

        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync([$adminId]);

        $serving = Serving::factory()->create();

        $response = $this->actingAs($user)->get(route('servings.create', [$serving->id]));

        $response->assertOk();
    }

    /**
     * test serving create form without permission.
     * 
     * @return void
     */
    public function testServingCreateFormWithoutPermission()
    {
        $serving = Serving::factory()->create();

        $response = $this->get(route('servings.create', [$serving->id]));

        $response->assertStatus(403);
    }

    /**
     * test create new serving.
     *
     * @return void
     */
    public function testNewServing()
    {
        $this->withoutExceptionHandling();

        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync([$adminId]);
        
        $response = $this->actingAs($user)
            ->post(route('servings.store'), [
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
        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync([$adminId]);
        
        $response = $this->actingAs($user)
            ->post(route('servings.store'), [
                'quantity' => null,
        ]);

        $response->assertSessionHasErrors(['quantity']);
    }

    /**
     * test create new serving without permission.
     *
     * @return void
     */
    public function testNewServingWithoutPermission()
    {
        $this->seed();
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
            ->post(route('servings.store'), [
                'quantity' => $this->faker->lexify('???'),
        ]);

        $response->assertStatus(403);
    }

    /**
     * test a serving can be shown.
     * 
     * @return void
     */
    public function testShowingserving()
    {
        $this->withoutExceptionHandling();

        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync([$adminId]);

        $serving = Serving::factory()->create();

        $response = $this->actingAs($user)->get(route('servings.show', [$serving->id]));

        $response->assertOk();
    }

    /**
     * test a serving can be shown without permission.
     * 
     * @return void
     */
    public function testShowingservingWithoutPermission()
    {
        $this->seed();
        $user = User::factory()->create();

        $serving = Serving::factory()->create();

        $response = $this->actingAs($user)->get(route('servings.show', [$serving->id]));

        $response->assertStatus(403);
    }

    /**
     * test serving edit form.
     * 
     * @return void
     */
    public function testservingEditForm()
    {
        $this->withoutExceptionHandling();

        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync([$adminId]);

        $serving = Serving::factory()->create();

        $response = $this->actingAs($user)->get(route('servings.edit', [$serving->id]));

        $response->assertOk();
    }

    /**
     * test serving edit form without permission.
     * 
     * @return void
     */
    public function testservingEditFormWithoutPermission()
    {
        $serving = Serving::factory()->create();

        $response = $this->get(route('servings.edit', [$serving->id]));

        $response->assertStatus(403);
    }

    /**
     * test a serving can be updated.
     * 
     * @return void
     */
    public function testServingCanBeUpdated()
    {
        $this->withoutExceptionHandling();

        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync([$adminId]);
        
        $serving = Serving::factory()->create();

        // new data
        $quantity = $this->faker->lexify('???');

        $response = $this->actingAs($user)
            ->patch(route('servings.update', [$serving->id]), [
                'quantity' => $quantity,
        ]);

        $this->assertEquals($quantity, Serving::first()->quantity);
        $response->assertRedirect($serving->path());
    }

    /**
     * test a serving can be updated without permission.
     * 
     * @return void
     */
    public function testServingCanBeUpdatedWithoutPermission()
    {
        $this->seed();
        $user = User::factory()->create();
        
        $serving = Serving::factory()->create();

        // new data
        $quantity = $this->faker->lexify('???');

        $response = $this->actingAs($user)
            ->patch(route('servings.update', [$serving->id]), [
                'quantity' => $quantity,
        ]);

        $response->assertStatus(403);
    }

    /**
     * test a serving can be deleted.
     * 
     * @return void
     */
    public function testServingCanBeDeleted()
    {
        $this->withoutExceptionHandling();

        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync([$adminId]);
        
        $serving = Serving::factory()->create();

        $this->assertDatabaseCount($serving->getTable(), 1);

        $this->ActingAs($user)
            ->delete(route('servings.destroy', [$serving->id]));

        $this->assertSoftDeleted($serving);
    }

    /**
     * test a serving can be deleted without permission.
     * 
     * @return void
     */
    public function testServingCanBeDeletedWithoutPermission()
    {
        $this->seed();
        $user = User::factory()->create();
        
        $serving = Serving::factory()->create();

        $this->assertDatabaseCount($serving->getTable(), 1);

        $response = $this->ActingAs($user)
            ->delete(route('servings.destroy', [$serving->id]));

        $response->assertStatus(403);
    }
}
