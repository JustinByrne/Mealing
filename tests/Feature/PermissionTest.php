<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Permission;
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
    }

    /**
     * test the index of permissions.
     * 
     * @return void
     */
    public function testCanAccessPermissionIndexPage()
    {
        $this->withoutExceptionHandling();
        $this->user->givePermissionTo('permission_access');
        
        $response = $this->actingAs($this->user)->get(route('admin.permissions.index'));

        $response->assertOk();
        $response->assertViewIs('admin.permissions.index');
    }

    /**
     * test the index of permissions without permission.
     * 
     * @return void
     */
    public function testDeniedAccessToPermissionIndexPageWithoutPermission()
    {
        $response = $this->get(route('admin.permissions.index'));

        $response->assertRedirect(route('login'));
    }

    /**
     * test permission create form.
     * 
     * @return void
     */
    public function testCanAccessCreatePermissionFormPage()
    {
        $this->withoutExceptionHandling();
        $this->user->givePermissionTo('permission_create');

        $permission = Permission::create(['name' => 'test']);

        $response = $this->actingAs($this->user)->get(route('admin.permissions.create', [$permission->id]));

        $response->assertOk();
        $response->assertViewIs('admin.permissions.create');
    }

    /**
     * test permission create form without permission.
     * 
     * @return void
     */
    public function testDeniedUnauthorisedAccessToCreatePermissionFormPageWhenNotLogeedIn()
    {
        $permission = Permission::create(['name' => 'test']);

        $response = $this->get(route('admin.permissions.create', [$permission->id]));

        $response->assertRedirect(route('login'));
    }

    /**
     * Test create a new permission.
     *
     * @return void
     */
    public function testCanCreateANewPermission()
    {
        $this->withoutExceptionHandling();
        $this->user->givePermissionTo('permission_create');

        $name = $this->faker->lexify('???');

        $response = $this->actingAs($this->user)->post(route('admin.permissions.store'), [
                'name' => $name,
        ]);

        $permission = Permission::first();

        $this->assertDatabaseHas('permissions', ['name' => $name]);
        $response->assertRedirect(route('admin.permissions.show', [Permission::where('name', $name)->first()]));
    }

    /**
     * Test create a new permission with name null.
     * 
     * @return void
     */
    public function testErrorWhenCreatingANewPermissionWithoutATitle()
    {
        $this->user->givePermissionTo('permission_create');
        
        $response = $this->actingAs($this->user)->post(route('admin.permissions.store'), [
                'name' => null,
        ]);

        $response->assertSessionHasErrors(['name']);
    }

    /**
     * Test create a new permission without permission.
     *
     * @return void
     */
    public function testDeniedAccessToCreateANewPermissionWithoutPermission()
    {
        $this->seed();
        $user = User::factory()->create();

        $title = $this->faker->lexify('???');

        $response = $this->actingAs($user)->post(route('admin.permissions.store'), [
                'title' => $title,
        ]);

        $response->assertForbidden();
    }

    /**
     * test a permission can be shown.
     * 
     * @return void
     */
    public function testCanAccessIndividualPermissionPage()
    {
        $this->withoutExceptionHandling();
        $this->user->givePermissionTo('permission_show');

        $permission = Permission::create(['name' => 'test']);

        $response = $this->actingAs($this->user)->get(route('admin.permissions.show', [$permission->id]));

        $response->assertOk();
        $response->assertViewIs('admin.permissions.show');
    }

    /**
     * test a permission can be shown without permission.
     * 
     * @return void
     */
    public function testDeniedAccessToIndividualPermissionPageWithoutPermission()
    {
        $user = User::factory()->create();

        $permission = Permission::create(['name' => 'test']);

        $response = $this->actingAs($user)->get(route('admin.permissions.show', [$permission->id]));

        $response->assertForbidden();
    }

    /**
     * test permission edit form.
     * 
     * @return void
     */
    public function testCanAccessEditPermissionFormPage()
    {
        $this->withoutExceptionHandling();
        $this->user->givePermissionTo('permission_edit');

        $permission = Permission::create(['name' => 'test']);

        $response = $this->actingAs($this->user)->get(route('admin.permissions.edit', [$permission->id]));

        $response->assertOk();
        $response->assertViewIs('admin.permissions.edit');
    }

    /**
     * test permission edit form without permission.
     * 
     * @return void
     */
    public function testDeniedUnauthorisedAccessToEditPermissionFormWhenNotLoggedIn()
    {
        $permission = Permission::create(['name' => 'test']);

        $response = $this->get(route('admin.permissions.edit', [$permission->id]));

        $response->assertRedirect(route('login'));
    }

    /**
     * Test a permission can be updated
     * 
     * @return void
     */
    public function testAPermissionCanBeUpdated()
    {
        $this->withoutExceptionHandling();
        $this->user->givePermissionTo('permission_edit');
        
        $permission = Permission::create(['name' => 'test']);

        $this->assertDatabaseHas('permissions', ['id' => $permission->id]);

        // new data
        $name = $this->faker->lexify('???');

        $response = $this->actingAs($this->user)
            ->patch(route('admin.permissions.update', $permission->id), [
                'name' => $name,
        ]);

        $this->assertDatabaseHas('permissions', ['name' => $name]);
        $response->assertRedirect(route('admin.permissions.show', [$permission]));
    }

    /**
     * Test a permission can be updated without permission.
     * 
     * @return void
     */
    public function testDeniedUpdatingAPermissionWithoutPermission()
    {
        $user = User::factory()->create();
        
        $permission = Permission::create(['name' => 'test']);

        $this->assertDatabaseHas('permissions', ['id' => $permission->id]);

        // new data
        $title = $this->faker->lexify('???');

        $response = $this->actingAs($user)
            ->patch(route('admin.permissions.update', $permission->id), [
                'title' => $title,
        ]);

        $response->assertForbidden();
    }

    /**
     * Test a permission can be deleted
     * 
     * @return void
     */
    public function testAPermissionCanBeDeleted()
    {
        $this->withoutExceptionHandling();
        $this->user->givePermissionTo('permission_delete');
        
        $permission = Permission::create(['name' => 'test']);

        $response = $this->actingAs($this->user)
            ->delete(route('admin.permissions.destroy', [$permission->id]));

        $this->assertDeleted($permission);
    }

    /**
     * Test a permission can be deleted without permission.
     * 
     * @return void
     */
    public function testDeniedAccessDeletingAPermissionWithoutPermission()
    {
        $user = User::factory()->create();
        
        $permission = Permission::create(['name' => 'test']);

        $response = $this->actingAs($user)
            ->delete(route('admin.permissions.destroy', [$permission->id]));

        $response->assertForbidden();
    }
}
