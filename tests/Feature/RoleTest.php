<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleTest extends TestCase
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
     * test the index of roles.
     * 
     * @return void
     */
    public function testCanAccessRoleIndexPage()
    {
        $this->withoutExceptionHandling();
        
        $response = $this->actingAs($this->user)->get(route('admin.roles.index'));

        $response->assertOk();
        $response->assertViewIs('admin.roles.index');
    }

    /**
     * test the index of roles without permission.
     * 
     * @return void
     */
    public function testDeniedAccessToRoleIndexPageWhenNotLoggedIn()
    {
        $response = $this->get(route('admin.roles.index'));

        $response->assertRedirect(route('login'));
    }

    /**
     * test role create form.
     * 
     * @return void
     */
    public function testCanAccessCreateRoleFormPage()
    {
        $this->withoutExceptionHandling();

        $role = Role::factory()->create();

        $response = $this->actingAs($this->user)->get(route('admin.roles.create', [$role->id]));

        $response->assertOk();
        $response->assertViewIs('admin.roles.create');
    }

    /**
     * test role create form without permission.
     * 
     * @return void
     */
    public function testDeniedAccessToCreateRoleFormWhenNotLoggedIn()
    {
        $role = Role::factory()->create();

        $response = $this->get(route('admin.roles.create', [$role->id]));

        $response->assertRedirect(route('login'));
    }
    
    /**
     * test create new role.
     *
     * @return void
     */
    public function testCanCreateANewRole()
    {
        $this->withoutExceptionHandling();

        $title = $this->faker->word;
        $description = $this->faker->paragraph;
        
        $response = $this->actingAs($this->user)->post(route('admin.roles.store'), [
            'title' => $title,
            'description' => $description
        ]);

        $role = Role::where('title', $title)->first();

        $this->assertDatabaseHas(Role::getTableName(), [
            'title' => $title,
            'description' => $description
        ]);
        $response->assertRedirect($role->path());
    }

    /**
     * test create new role with null title.
     *
     * @return void
     */
    public function testErrorWhenCreatingANewRoleWithoutATitle()
    {
        $response = $this->actingAs($this->user)
            ->post(route('admin.roles.store'), [
                'title' => null,
        ]);

        $response->assertSessionHasErrors(['title']);
    }

    /**
     * test create new role without permission.
     *
     * @return void
     */
    public function testDeniedAccessToCreateANewRoleWithoutPermission()
    {
        $user = User::factory()->create();

        $title = $this->faker->word;
        $description = $this->faker->paragraph;
        
        $response = $this->actingAs($user)->post(route('admin.roles.store'), [
            'title' => $title,
            'description' => $description
        ]);

        $response->assertForbidden();
    }

    /**
     * test a role can be shown.
     * 
     * @return void
     */
    public function testCanAccessIndividualRolePage()
    {
        $this->withoutExceptionHandling();

        $role = Role::factory()->create();

        $response = $this->actingAs($this->user)->get(route('admin.roles.show', [$role->id]));

        $response->assertOk();
        $response->assertViewIs('admin.roles.show');
    }

    /**
     * test a role can be shown without permission.
     * 
     * @return void
     */
    public function testDeniedAccessToIndividualRolePageWithoutPermission()
    {
        $user = User::factory()->create();
        $role = Role::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.roles.show', [$role->id]));

        $response->assertForbidden();
    }

    /**
     * test role edit form.
     * 
     * @return void
     */
    public function testCanAccessEditRoleFormPage()
    {
        $this->withoutExceptionHandling();

        $role = Role::factory()->create();

        $response = $this->actingAs($this->user)->get(route('admin.roles.edit', [$role->id]));

        $response->assertOk();
        $response->assertViewIs('admin.roles.edit');
    }

    /**
     * test role edit form without permission.
     * 
     * @return void
     */
    public function testDeniedAccessToEditRoleFormPageWithoutPermission()
    {
        $role = Role::factory()->create();

        $response = $this->get(route('admin.roles.edit', [$role->id]));

        $response->assertRedirect(route('login'));
    }

    /**
     * test a role can be updated.
     * 
     * @return void
     */
    public function testARoleCanBeUpdated()
    {
        $this->withoutExceptionHandling();
        
        $role = Role::factory()->create();

        // new data
        $title = $this->faker->word;
        $description = $this->faker->paragraph;

        $response = $this->actingAs($this->user)
            ->patch(route('admin.roles.update', [$role->id]), [
                'title' => $title,
                'description' => $description
        ]);

        $this->assertDatabaseHas(Role::getTableName(), [
            'title' => $title,
            'description' => $description
        ]);
        $response->assertRedirect($role->path());
    }

    /**
     * test a role can be updated without permission.
     * 
     * @return void
     */
    public function testDeniedAccessToUpdateARoleWithoutPermission()
    {
        $user = User::factory()->create();
        $role = Role::factory()->create();

        // new data
        $title = $this->faker->word;

        $response = $this->actingAs($user)
            ->patch(route('admin.roles.update', [$role->id]), [
                'title' => $title,
        ]);

        $response->assertForbidden();
    }

    /**
     * test a role can be deleted.
     * 
     * @return void
     */
    public function testARoleCanBeDeleted()
    {
        $this->withoutExceptionHandling();

        $role = Role::factory()->create();

        $this->assertDatabaseHas(Role::getTableName(), ['id' => $role->id]);

        $response = $this->actingAs($this->user)
            ->delete(route('admin.roles.destroy', [$role->id]));

        $this->assertSoftDeleted($role);
    }

    /**
     * test a role can be deleted without permission.
     * 
     * @return void
     */
    public function testDeniedAccessToDeleteARoleWithoutPermission()
    {
        $user = User::factory()->create();
        $role = Role::factory()->create();

        $this->assertDatabaseHas(Role::getTableName(), ['id' => $role->id]);

        $response = $this->actingAs($user)
            ->delete(route('admin.roles.destroy', [$role->id]));

        $response->assertForbidden();
    }
}
