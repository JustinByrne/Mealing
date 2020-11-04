<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Permission;

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

        $response = $this->post(route('permissions.store'), [
            'title' => $this->faker->lexify('???'),
        ]);

        $permission = Permission::first();

        $this->assertDatabaseCount($permission->getTable(), 1);
        $response->assertRedirect($permission->path());
    }

    /**
     * Test create a new permission with title null.
     * 
     * @return void
     */
    public function testNewPermissionWithTitleNull()
    {
        $response = $this->post(route('permissions.store'), [
            'title' => null,
        ]);

        $response->assertSessionHasErrors(['title']);
    }

    /**
     * Test a permission can be updated
     * 
     * @return void
     */
    public function testPermissionCanBeUpdated()
    {
        $permission = Permission::factory()->create();

        $this->assertDatabaseCount($permission->getTable(), 1);

        // new data
        $title = $this->faker->lexify('???');

        $response = $this->patch(route('permissions.update', $permission->id), [
            'title' => $title,
        ]);

        $this->assertEquals($title, Permission::first()->title);
        $response->assertRedirect($permission->path());
    }

    /**
     * Test a permission can be deleted
     * 
     * @return void
     */
    public function testPermissionCanBeDeleted()
    {
        $permission = Permission::factory()->create();

        $response = $this->delete(route('permissions.destroy', [$permission->id]));

        $this->assertSoftDeleted($permission);
    }
}
