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
    public function testCanAccessPermissionIndexPage()
    {
        $this->withoutExceptionHandling();
        
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

        $permission = Permission::factory()->create();

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
        $permission = Permission::factory()->create();

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

        $title = $this->faker->lexify('???');

        $response = $this->actingAs($this->user)->post(route('admin.permissions.store'), [
                'title' => $title,
        ]);

        $permission = Permission::first();

        $this->assertDatabaseHas(Permission::getTableName(), ['title' => $title]);
        $response->assertRedirect(Permission::where('title', $title)->first()->path());
    }

    /**
     * Test create a new permission with title null.
     * 
     * @return void
     */
    public function testErrorWhenCreatingANewPermissionWithoutATitle()
    {
        $response = $this->actingAs($this->user)->post(route('admin.permissions.store'), [
                'title' => null,
        ]);

        $response->assertSessionHasErrors(['title']);
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

        $permission = Permission::factory()->create();

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

        $permission = Permission::factory()->create();

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

        $permission = Permission::factory()->create();

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
        $permission = Permission::factory()->create();

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
        
        $permission = Permission::factory()->create();

        $this->assertDatabaseHas(Permission::getTableName(), ['id' => $permission->id]);

        // new data
        $title = $this->faker->lexify('???');

        $response = $this->actingAs($this->user)
            ->patch(route('admin.permissions.update', $permission->id), [
                'title' => $title,
        ]);

        $this->assertDatabaseHas(Permission::getTableName(), ['title' => $title]);
        $response->assertRedirect($permission->path());
    }

    /**
     * Test a permission can be updated without permission.
     * 
     * @return void
     */
    public function testDeniedUpdatingAPermissionWithoutPermission()
    {
        $user = User::factory()->create();
        
        $permission = Permission::factory()->create();

        $this->assertDatabaseHas(Permission::getTableName(), ['id' => $permission->id]);

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
        
        $permission = Permission::factory()->create();

        $response = $this->actingAs($this->user)
            ->delete(route('admin.permissions.destroy', [$permission->id]));

        $this->assertSoftDeleted($permission);
    }

    /**
     * Test a permission can be deleted without permission.
     * 
     * @return void
     */
    public function testDeniedAccessDeletingAPermissionWithoutPermission()
    {
        $user = User::factory()->create();
        
        $permission = Permission::factory()->create();

        $response = $this->actingAs($user)
            ->delete(route('admin.permissions.destroy', [$permission->id]));

        $response->assertForbidden();
    }
}
