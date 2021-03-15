<?php

namespace Tests\Feature;

use Hash;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
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
     * Test all users can be found.
     *
     * @return void
     */
    public function testCanAccessUserIndexPage()
    {
        $this->withoutExceptionHandling();
        $this->user->givePermissionTo('user_access');

        $response = $this->actingAs($this->user)->get(route('admin.users.index'));

        $response->assertOk();
        $response->assertViewIs('admin.users.index');
    }

    /**
     * Test all user can be found without permission.
     * 
     * @return void
     */
    public function testDeniedAccesToUserIndexPageWithoutPermission()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.users.index'));

        $response->assertForbidden();
    }

    /**
     * Test the create form.
     * 
     * @return void
     */
    public function testCanAccessCreateUserFormPage()
    {
        $this->withoutExceptionHandling();
        $this->user->givePermissionTo('user_create');

        $response = $this->actingAs($this->user)->get(route('admin.users.create'));

        $response->assertOk();
        $response->assertViewIs('admin.users.create');
    }

    /**
     * Test the create form without permisison.
     * 
     * @return void
     */
    public function testDeniedAccessToCreateUserFormPageWithoutPermission()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.users.create'));

        $response->assertForbidden();
    }

    /**
     * Test creating new user.
     * 
     * @return void
     */
    public function testCanCreateANewUser()
    {
        $this->withoutExceptionHandling();
        $this->user->givePermissionTo('user_create');

        $email = $this->faker->unique()->safeEmail;

        $response = $this->actingAs($this->user)
            ->post(route('admin.users.store'), [
                'name' => $this->faker->name,
                'email' => $email,
                'password' => 'password',
                'password_confirmation' => 'password',
        ]);

        $newUser = User::where('email', $email)->first();

        $this->assertDatabaseHas(User::getTableName(), ['email' => $email]);
        $response->assertRedirect($newUser->path());
    }

    /**
     * Test creating new user without permission.
     * 
     * @return void
     */
    public function testDeniedAccessToCreateANewUserWithoutPermission()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('admin.users.store'), [
                'name' => $this->faker->name,
                'email' => $this->faker->unique()->safeEmail,
                'password' => 'password',
                'password_confirmation' => 'password',
        ]);

        $response->assertForbidden();
    }

    /**
     * Test show user page.
     * 
     * @return void
     */
    public function testCanAccessIndividualUserPage()
    {
        $this->withoutExceptionHandling();
        $this->user->givePermissionTo('user_show');

        $newUser = User::factory()->create();

        $response = $this->actingAs($this->user)->get($newUser->path());

        $response->assertOk();
        $response->assertViewIs('admin.users.show');
    }

    /**
     * Test show user page without permission.
     * 
     * @return void
     */
    public function testDeniedAccessToIndividualUserPageWithoutPermission()
    {
        $user = User::factory()->create();
        $newUser = User::factory()->create();

        $response = $this->actingAs($user)->get($newUser->path());

        $response->assertForbidden();
    }

    /**
     * Test the edit form.
     * 
     * @return void
     */
    public function testCanAccessEditUserFormPage()
    {
        $this->withoutExceptionHandling();
        $this->user->givePermissionTo('user_edit');

        $newUser = User::factory()->create();

        $response = $this->actingAs($this->user)->get(route('admin.users.edit', [$newUser->id]));

        $response->assertOk();
        $response->assertViewIs('admin.users.edit');
    }

    /**
     * Test the edit form without permission.
     * 
     * @return void
     */
    public function testDeniedAccessToEditUserFormPageWithoutPermission()
    {
        $user = User::factory()->create();
        $newUser = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.users.edit', [$newUser->id]));

        $response->assertForbidden();
    }

    /**
     * Test a user can be updated.
     * 
     * @return void
     */
    public function testAUserCanBeUpdated()
    {
        $this->withoutExceptionHandling();
        $this->user->givePermissionTo('user_edit');

        $newUser = User::factory()->create();

        // new data
        $name = $this->faker->name;
        $email = $this->faker->unique()->safeEmail;
        $password = 'password';

        $response = $this->actingAs($this->user)->patch(route('admin.users.update', [$newUser->id]), [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $this->assertDatabaseHas(User::getTableName(), [
            'name' => $name,
            'email' => $email,
        ]);

        $this->assertTrue(Hash::check($password, $newUser->password));

        $response->assertRedirect($newUser->path());
    }

    /**
     * Test a user can be updated wihtout permission.
     * 
     * @return void
     */
    public function testDeniedAccessToUpdateAUserWithoutPermission()
    {
        $user = User::factory()->create();
        $newUser = User::factory()->create();

        // new data
        $name = $this->faker->name;
        $email = $this->faker->unique()->safeEmail;
        $password = 'password';

        $response = $this->actingAs($user)->patch(route('admin.users.update', [$newUser->id]), [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $response->assertForbidden();
    }

    /**
     * Test a user can be deleted.
     * 
     * @return void
     */
    public function testAUserCanBeDeleted()
    {
        $this->withoutExceptionHandling();
        $this->user->givePermissionTo('user_delete');

        $newUser = User::factory()->create();

        $response = $this->actingAs($this->user)->delete(route('admin.users.destroy', [$newUser->id]));

        $this->assertSoftDeleted($newUser);
    }

    /**
     * Test a user can be deleted without permission.
     * 
     * @return void
     */
    public function testDeniedAccessToDeleteAUserWithoutPermission()
    {
        $user = User::factory()->create();
        $newUser = User::factory()->create();

        $response = $this->actingAs($user)->delete(route('admin.users.destroy', [$newUser->id]));

        $response->assertForbidden();
    }
}
