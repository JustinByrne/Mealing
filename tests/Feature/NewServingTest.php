<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Serving;
use App\Models\User;
use App\Models\Role;

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
