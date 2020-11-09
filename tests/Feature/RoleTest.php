<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Role;
use App\Models\User;

class RoleTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * test the index of roles.
     * 
     * @return void
     */
    public function testRoleIndex()
    {
        $this->withoutExceptionHandling();

        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync([$adminId]);
        
        $response = $this->actingAs($user)->get(route('roles.index'));

        $response->assertOk();
    }

    /**
     * test the index of roles without permission.
     * 
     * @return void
     */
    public function testRoleIndexWithoutPermission()
    {
        $response = $this->get(route('roles.index'));

        $response->assertStatus(403);
    }

    /**
     * test role create form.
     * 
     * @return void
     */
    public function testRoleCreateForm()
    {
        $this->withoutExceptionHandling();

        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync([$adminId]);

        $role = Role::factory()->create();

        $response = $this->actingAs($user)->get(route('roles.create', [$role->id]));

        $response->assertOk();
    }

    /**
     * test role create form without permission.
     * 
     * @return void
     */
    public function testRoleCreateFormWithoutPermission()
    {
        $role = Role::factory()->create();

        $response = $this->get(route('roles.create', [$role->id]));

        $response->assertStatus(403);
    }
    
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
     * test create new role without permission.
     *
     * @return void
     */
    public function testNewRoleWithoutPermission()
    {
        $this->seed();
        $user = User::factory()->create();

        $title = $this->faker->lexify('???');
        
        $response = $this->actingAs($user)
            ->post(route('roles.store'), [
                'title' => $title,
        ]);

        $response->assertStatus(403);
    }

    /**
     * test a role can be shown.
     * 
     * @return void
     */
    public function testShowingRole()
    {
        $this->withoutExceptionHandling();

        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync([$adminId]);

        $role = Role::factory()->create();

        $response = $this->actingAs($user)->get(route('roles.show', [$role->id]));

        $response->assertOk();
    }

    /**
     * test a role can be shown without permission.
     * 
     * @return void
     */
    public function testShowingRoleWithoutPermission()
    {
        $this->seed();
        $user = User::factory()->create();

        $role = Role::factory()->create();

        $response = $this->actingAs($user)->get(route('roles.show', [$role->id]));

        $response->assertStatus(403);
    }

    /**
     * test role edit form.
     * 
     * @return void
     */
    public function testRoleEditForm()
    {
        $this->withoutExceptionHandling();

        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync([$adminId]);

        $role = Role::factory()->create();

        $response = $this->actingAs($user)->get(route('roles.edit', [$role->id]));

        $response->assertOk();
    }

    /**
     * test role edit form without permission.
     * 
     * @return void
     */
    public function testRoleEditFormWithoutPermission()
    {
        $role = Role::factory()->create();

        $response = $this->get(route('roles.edit', [$role->id]));

        $response->assertStatus(403);
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
     * test a role can be updated without permission.
     * 
     * @return void
     */
    public function testRoleCanBeUpdatedWithoutPermission()
    {
        $this->seed();
        $user = User::factory()->create();
        
        $role = Role::factory()->create();

        // new data
        $title = $this->faker->lexify('???');

        $response = $this->actingAs($user)
            ->patch(route('roles.update', [$role->id]), [
                'title' => $title,
        ]);

        $response->assertStatus(403);
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

    /**
     * test a role can be deleted without permission.
     * 
     * @return void
     */
    public function testRoleCanBeDeletedWithoutPermission()
    {
        $this->seed();
        $user = User::factory()->create();

        $role = Role::factory()->create();

        $this->assertDatabaseHas($role->getTable(), ['id' => $role->id]);

        $response = $this->actingAs($user)
            ->delete(route('roles.destroy', [$role->id]));

        $response->assertStatus(403);
    }
}