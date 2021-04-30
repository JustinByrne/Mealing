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
}
