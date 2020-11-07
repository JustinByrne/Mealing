<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Permission;
use App\Models\User;
use App\Models\Role;

class NewPermissionTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * Test create a new permission.
     *
     * @return void
     */
    public function testNewPermission()
    {
        $this->withoutExceptionHandling();

        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync([$adminId]);

        $title = $this->faker->lexify('???');

        $response = $this->actingAs($user)
            ->post(route('permissions.store'), [
                'title' => $title,
        ]);

        $permission = Permission::first();

        $this->assertDatabaseHas($permission->getTable(), ['title' => $title]);
        $response->assertRedirect(Permission::where('title', $title)->first()->path());
    }

    /**
     * Test create a new permission with title null.
     * 
     * @return void
     */
    public function testNewPermissionWithTitleNull()
    {
        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync([$adminId]);
        
        $response = $this->actingAs($user)
            ->post(route('permissions.store'), [
                'title' => null,
        ]);

        $response->assertSessionHasErrors(['title']);
    }

    /**
     * Test create a new permission without permission.
     *
     * @return void
     */
    public function testNewPermissionWithoutPermission()
    {
        $this->seed();
        $user = User::factory()->create();

        $title = $this->faker->lexify('???');

        $response = $this->actingAs($user)
            ->post(route('permissions.store'), [
                'title' => $title,
        ]);

        $response->assertStatus(403);
    }

    /**
     * Test a permission can be updated
     * 
     * @return void
     */
    public function testPermissionCanBeUpdated()
    {
        $this->withoutExceptionHandling();

        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync([$adminId]);
        
        $permission = Permission::factory()->create();

        $this->assertDatabaseHas($permission->getTable(), ['id' => $permission->id]);

        // new data
        $title = $this->faker->lexify('???');

        $response = $this->actingAs($user)
            ->patch(route('permissions.update', $permission->id), [
                'title' => $title,
        ]);

        $this->assertDatabaseHas($permission->getTable(), ['title' => $title]);
        $response->assertRedirect($permission->path());
    }

    /**
     * Test a permission can be updated without permission.
     * 
     * @return void
     */
    public function testPermissionCanBeUpdatedWithoutPermission()
    {
        $this->seed();
        $user = User::factory()->create();
        
        $permission = Permission::factory()->create();

        $this->assertDatabaseHas($permission->getTable(), ['id' => $permission->id]);

        // new data
        $title = $this->faker->lexify('???');

        $response = $this->actingAs($user)
            ->patch(route('permissions.update', $permission->id), [
                'title' => $title,
        ]);

        $response->assertStatus(403);
    }

    /**
     * Test a permission can be deleted
     * 
     * @return void
     */
    public function testPermissionCanBeDeleted()
    {
        $this->withoutExceptionHandling();

        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync([$adminId]);
        
        $permission = Permission::factory()->create();

        $response = $this->actingAs($user)
            ->delete(route('permissions.destroy', [$permission->id]));

        $this->assertSoftDeleted($permission);
    }

    /**
     * Test a permission can be deleted without permission.
     * 
     * @return void
     */
    public function testPermissionCanBeDeletedWithoutPermission()
    {
        $this->seed();
        $user = User::factory()->create();
        
        $permission = Permission::factory()->create();

        $response = $this->actingAs($user)
            ->delete(route('permissions.destroy', [$permission->id]));

        $response->assertStatus(403);
    }
}
