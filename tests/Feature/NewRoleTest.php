<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Role;
use App\Models\User;

class NewRoleTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    
    /**
     * test create new role.
     *
     * @return void
     */
    public function testNewRole()
    {
        $this->withoutExceptionHandling();

        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync([$adminId]);

        $title = $this->faker->lexify('???');
        
        $response = $this->actingAs($user)
            ->post(route('roles.store'), [
                'title' => $title,
        ]);

        $role = Role::where('title', $title)->first();

        $this->assertDatabaseHas($role->getTable(), ['title' => $title]);
        $response->assertRedirect($role->path());
    }

    /**
     * test create new role with null title.
     *
     * @return void
     */
    public function testNewRoleWithTitleNull()
    {
        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync([$adminId]);
        
        $response = $this->actingAs($user)
            ->post(route('roles.store'), [
                'title' => null,
        ]);

        $response->assertSessionHasErrors(['title']);
    }

    /**
     * test a role can be updated.
     * 
     * @return void
     */
    public function testRoleCanBeUpdated()
    {
        $this->withoutExceptionHandling();

        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync([$adminId]);
        
        $role = Role::factory()->create();

        // new data
        $title = $this->faker->lexify('???');

        $response = $this->actingAs($user)
            ->patch(route('roles.update', [$role->id]), [
                'title' => $title,
        ]);

        $this->assertDatabaseHas($role->getTable(), ['title' => $title]);
        $response->assertRedirect($role->path());
    }

    /**
     * test a role can be deleted.
     * 
     * @return void
     */
    public function testRoleCanBeDeleted()
    {
        $this->withoutExceptionHandling();

        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync([$adminId]);

        $role = Role::factory()->create();

        $this->assertDatabaseHas($role->getTable(), ['id' => $role->id]);

        $response = $this->actingAs($user)
            ->delete(route('roles.destroy', [$role->id]));

        $this->assertSoftDeleted($role);
    }
}
