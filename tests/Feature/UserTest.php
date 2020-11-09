<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;

class UserTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * Test all users can be found.
     *
     * @return void
     */
    public function testUserIndexPage()
    {
        $this->withoutExceptionHandling();

        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync($adminId);

        $response = $this->actingAs($user)->get(route('users.index'));

        $response->assertOk();
    }

    /**
     * Test all user can be found without permission.
     * 
     * @return void
     */
    public function testUserIndexPageWithoutPermission()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('users.index'));

        $response->assertStatus(403);
    }

    /**
     * Test the create form.
     * 
     * @return void
     */
    public function testUserCreateForm()
    {
        $this->withoutExceptionHandling();

        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync($adminId);

        $response = $this->actingAs($user)->get(route('users.create'));

        $response->assertOk();
    }

    /**
     * Test the create form without permisison.
     * 
     * @return void
     */
    public function testUserCreateFormWithoutPermission()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('users.create'));

        $response->assertStatus(403);
    }

    /**
     * Test creating new user.
     * 
     * @return void
     */
    public function testNewUser()
    {
        $this->withoutExceptionHandling();

        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync($adminId);

        $email = $this->faker->unique()->safeEmail;

        $response = $this->actingAs($user)
            ->post(route('users.store'), [
                'name' => $this->faker->name,
                'email' => $email,
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'password_confirmation' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);

        $newUser = User::where('email', $email)->first();

        $this->assertDatabaseHas($newUser->getTable(), ['email' => $email]);
        $response->assertRedirect($newUser->path());
    }

    /**
     * Test creating new user without permission.
     * 
     * @return void
     */
    public function testNewUserWithoutPermission()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('users.store'), [
                'name' => $this->faker->name,
                'email' => $this->faker->unique()->safeEmail,
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'password_confirmation' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);

        $response->assertStatus(403);
    }

    /**
     * Test show user page.
     * 
     * @return void
     */
    public function testUserShowPage()
    {
        $this->withoutExceptionHandling();

        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync($adminId);

        $newUser = User::factory()->create();

        $response = $this->actingAs($user)->get($newUser->path());

        $response->assertOk();
    }

    /**
     * Test show user page without permission.
     * 
     * @return void
     */
    public function testUserShowPageWithoutPermission()
    {
        $user = User::factory()->create();

        $newUser = User::factory()->create();

        $response = $this->actingAs($user)->get($newUser->path());

        $response->assertStatus(403);
    }

    /**
     * Test the edit form.
     * 
     * @return void
     */
    public function testUserEditForm()
    {
        $this->withoutExceptionHandling();

        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync($adminId);

        $newUser = User::factory()->create();

        $response = $this->actingAs($user)->get(route('users.edit', [$newUser->id]));

        $response->assertOk();
    }

    /**
     * Test the edit form without permission.
     * 
     * @return void
     */
    public function testUserEditFormWithoutPermission()
    {
        $user = User::factory()->create();

        $newUser = User::factory()->create();

        $response = $this->actingAs($user)->get(route('users.edit', [$newUser->id]));

        $response->assertStatus(403);
    }

    /**
     * Test a user can be updated.
     * 
     * @return void
     */
    public function testUserCanBeUpdated()
    {
        $this->withoutExceptionHandling();

        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync($adminId);

        $newUser = User::factory()->create();

        // new data
        $name = $this->faker->name;
        $email = $this->faker->unique()->safeEmail;
        $password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'; // password
        $password_confirmation = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'; // password

        $response = $this->actingAs($user)->patch(route('users.update', [$newUser->id]), [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password_confirmation,
        ]);

        $this->assertDatabaseHas($newUser->getTable(), [
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);
        $response->assertRedirect($newUser->path());
    }

    /**
     * Test a user can be updated wihtout permission.
     * 
     * @return void
     */
    public function testUserCanBeUpdatedWithoutPermission()
    {
        $user = User::factory()->create();

        $newUser = User::factory()->create();

        // new data
        $name = $this->faker->name;
        $email = $this->faker->unique()->safeEmail;
        $password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'; // password
        $password_confirmation = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'; // password

        $response = $this->actingAs($user)->patch(route('users.update', [$newUser->id]), [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password_confirmation,
        ]);

        $response->assertStatus(403);
    }

    /**
     * Test a user can be deleted.
     * 
     * @return void
     */
    public function testUserCanBeDeleted()
    {
        $this->withoutExceptionHandling();

        $this->seed();
        $user = User::factory()->create();
        $adminId = Role::find(1)->id;
        $user->roles()->sync($adminId);

        $newUser = User::factory()->create();

        $response = $this->actingAs($user)->delete(route('users.destroy', [$newUser->id]));

        $this->assertSoftDeleted($newUser);
    }

    /**
     * Test a user can be deleted without permission.
     * 
     * @return void
     */
    public function testUserCanBeDeletedWithoutPermission()
    {
        $user = User::factory()->create();

        $newUser = User::factory()->create();

        $response = $this->actingAs($user)->delete(route('users.destroy', [$newUser->id]));

        $response->assertStatus(403);
    }
}
