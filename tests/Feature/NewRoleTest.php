<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Role;

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
        
        $response = $this->post(route('roles.store'), [
            'title' => $this->faker->lexify('???'),
        ]);

        $role = Role::first();

        $this->assertDatabaseCount($role->getTable(), 1);
        $response->assertRedirect($role->path());
    }

    /**
     * test create new role with null title.
     *
     * @return void
     */
    public function testNewRoleWithTitleNull()
    {
        $response = $this->post(route('roles.store'), [
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
        
        $role = Role::factory()->create();

        // new data
        $title = $this->faker->lexify('???');

        $response = $this->patch(route('roles.update', [$role->id]), [
            'title' => $title,
        ]);

        $this->assertEquals($title, Role::first()->title);
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

        $role = Role::factory()->create();

        $this->assertDatabaseCount($role->getTable(), 1);

        $response = $this->delete(route('roles.destroy', [$role->id]));

        $this->assertSoftDeleted($role);
    }
}
