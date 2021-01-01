<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PermissionTest extends TestCase
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
     * test the index of permissions.
     * 
     * @return void
     */
    public function testPermissionIndex()
    {
        $this->withoutExceptionHandling();
        
        $response = $this->actingAs($this->user)->get(route('permissions.index'));

        $response->assertOk();
    }

    /**
     * test the index of permissions without permission.
     * 
     * @return void
     */
    public function testPermissionIndexWithoutPermission()
    {
        $response = $this->get(route('permissions.index'));

        $response->assertRedirect(route('login'));
    }

    /**
     * test permission create form.
     * 
     * @return void
     */
    public function testPermissionCreateForm()
    {
        $this->withoutExceptionHandling();

        $permission = Permission::factory()->create();

        $response = $this->actingAs($this->user)->get(route('permissions.create', [$permission->id]));

        $response->assertOk();
    }

    /**
     * test permission create form without permission.
     * 
     * @return void
     */
    public function testPermissionCreateFormWithoutPermission()
    {
        $permission = Permission::factory()->create();

        $response = $this->get(route('permissions.create', [$permission->id]));

        $response->assertRedirect(route('login'));
    }

    /**
     * Test create a new permission.
     *
     * @return void
     */
    public function testNewPermission()
    {
        $this->withoutExceptionHandling();

        $title = $this->faker->lexify('???');

        $response = $this->actingAs($this->user)
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
        $response = $this->actingAs($this->user)
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

        $response->assertForbidden();
    }

    /**
     * test a permission can be shown.
     * 
     * @return void
     */
    public function testShowingPermission()
    {
        $this->withoutExceptionHandling();

        $permission = Permission::factory()->create();

        $response = $this->actingAs($this->user)->get(route('permissions.show', [$permission->id]));

        $response->assertOk();
    }

    /**
     * test a permission can be shown without permission.
     * 
     * @return void
     */
    public function testShowingPermissionWithoutPermission()
    {
        $user = User::factory()->create();

        $permission = Permission::factory()->create();

        $response = $this->actingAs($user)->get(route('permissions.show', [$permission->id]));

        $response->assertForbidden();
    }

    /**
     * test permission edit form.
     * 
     * @return void
     */
    public function testPermissionEditForm()
    {
        $this->withoutExceptionHandling();

        $permission = Permission::factory()->create();

        $response = $this->actingAs($this->user)->get(route('permissions.edit', [$permission->id]));

        $response->assertOk();
    }

    /**
     * test permission edit form without permission.
     * 
     * @return void
     */
    public function testPermissionEditFormWithoutPermission()
    {
        $permission = Permission::factory()->create();

        $response = $this->get(route('permissions.edit', [$permission->id]));

        $response->assertRedirect(route('login'));
    }

    /**
     * Test a permission can be updated
     * 
     * @return void
     */
    public function testPermissionCanBeUpdated()
    {
        $this->withoutExceptionHandling();
        
        $permission = Permission::factory()->create();

        $this->assertDatabaseHas($permission->getTable(), ['id' => $permission->id]);

        // new data
        $title = $this->faker->lexify('???');

        $response = $this->actingAs($this->user)
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
        $user = User::factory()->create();
        
        $permission = Permission::factory()->create();

        $this->assertDatabaseHas($permission->getTable(), ['id' => $permission->id]);

        // new data
        $title = $this->faker->lexify('???');

        $response = $this->actingAs($user)
            ->patch(route('permissions.update', $permission->id), [
                'title' => $title,
        ]);

        $response->assertForbidden();
    }

    /**
     * Test a permission can be deleted
     * 
     * @return void
     */
    public function testPermissionCanBeDeleted()
    {
        $this->withoutExceptionHandling();
        
        $permission = Permission::factory()->create();

        $response = $this->actingAs($this->user)
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
        $user = User::factory()->create();
        
        $permission = Permission::factory()->create();

        $response = $this->actingAs($user)
            ->delete(route('permissions.destroy', [$permission->id]));

        $response->assertForbidden();
    }
}
