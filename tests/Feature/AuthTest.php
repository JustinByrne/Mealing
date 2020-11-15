<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test the registration form.
     *
     * @return void
     */
    public function testRegistrationForm()
    {
        $this->withoutExceptionHandling();
        
        $response = $this->get(route('register'));

        $response->assertOk();
    }

    /**
     * Test new user can be created.
     * 
     * @return void
     */
    public function testNewUserRegistered()
    {
        $this->withoutExceptionHandling();

        $email = $this->faker->unique()->safeEmail;

        $response = $this->post(route('register.store'), [
            'name' => $this->faker->name,
            'email' => $email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertDatabaseHas('users', ['email' => $email]);
    }

    /**
     * Test new user can be created with name null.
     * 
     * @return void
     */
    public function testNewUserRegisteredWithNameNull()
    {
        $response = $this->post(route('register.store'), [
            'name' => null,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors(['name']);
    }

    /**
     * Test new user can be created with email null.
     * 
     * @return void
     */
    public function testNewUserRegisteredWithEmailNull()
    {
        $response = $this->post(route('register.store'), [
            'name' => $this->faker->name,
            'email' => null,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /**
     * Test new user can be created with email duplicate.
     * 
     * @return void
     */
    public function testNewUserRegisteredWithEmailDuplicate()
    {
        $user = User::factory()->create();

        $response = $this->post(route('register.store'), [
            'name' => $this->faker->name,
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /**
     * Test new user can be created with password null.
     * 
     * @return void
     */
    public function testNewUserRegisteredWithPasswordNull()
    {
        $response = $this->post(route('register.store'), [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => null,
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    /**
     * Test new user can be created with password confirmation null.
     * 
     * @return void
     */
    public function testNewUserRegisteredWithPasswordConfirmNull()
    {
        $response = $this->post(route('register.store'), [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password',
            'password_confirmation' => null,
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    /**
     * Test the login screen
     * 
     * @return void
     */
    public function testLoginForm()
    {
        $this->withoutExceptionHandling();
        
        $response = $this->get(route('login'));

        $response->assertOk();
    }

    /**
     * Test login authentication
     * 
     * @return void
     */
    public function testLoginAuthentication()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $this->assertDatabaseHas($user->getTable(), $user->toArray());

        $response = $this->post(route('login.authenticate'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test login authentication with email null
     * 
     * @return void
     */
    public function testLoginAuthenticationWithEmailNull()
    {
        $response = $this->post(route('login.authenticate'), [
            'email' => null,
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /**
     * Test login authentication with password null
     * 
     * @return void
     */
    public function testLoginAuthenticationWithPasswordNull()
    {
        $user = User::factory()->create();

        $this->assertDatabaseHas($user->getTable(), $user->toArray());
        
        $response = $this->post(route('login.authenticate'), [
            'email' => $user->email,
            'password' => null,
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    /**
     * Test login authentication with not existing user
     * 
     * @return void
     */
    public function testLoginAuthenticationWithEmailDoesntExists()
    {
        $response = $this->post(route('login.authenticate'), [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors(['failed']);
    }

    /**
     * Test login authentication with incorrect password
     * 
     * @return void
     */
    public function testLoginAuthenticationWithIncorrectPassword()
    {
        $user = User::factory()->create();

        $this->assertDatabaseHas($user->getTable(), $user->toArray());

        $response = $this->post(route('login.authenticate'), [
            'email' => $user->email,
            'password' => 'let me in',
        ]);

        $response->assertSessionHasErrors(['failed']);
    }
}
