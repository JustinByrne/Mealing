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

        $response = $this->post(route('register'), [
            'name' => $this->faker->name,
            'email' => $email,
            'password' => 'password',
            'password_confirmation' => 'password',
            'recaptcha_token' => true,
        ]);

        $this->assertDatabaseHas('users', ['email' => $email]);
        $response->assertRedirect(route('dashboard'));
    }

    /**
     * Test new user can be created with name null.
     * 
     * @return void
     */
    public function testNewUserRegisteredWithNameNull()
    {
        $response = $this->post(route('register'), [
            'name' => null,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password',
            'password_confirmation' => 'password',
            'recaptcha_token' => true,
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
        $response = $this->post(route('register'), [
            'name' => $this->faker->name,
            'email' => null,
            'password' => 'password',
            'password_confirmation' => 'password',
            'recaptcha_token' => true,
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

        $response = $this->post(route('register'), [
            'name' => $this->faker->name,
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
            'recaptcha_token' => true,
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
        $response = $this->post(route('register'), [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => null,
            'password_confirmation' => 'password',
            'recaptcha_token' => true,
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
        $response = $this->post(route('register'), [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password',
            'password_confirmation' => null,
            'recaptcha_token' => true,
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

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password',
            'recaptcha_token' => true,
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('dashboard'));
    }

    /**
     * Test login authentication with email null
     * 
     * @return void
     */
    public function testLoginAuthenticationWithEmailNull()
    {
        $response = $this->post(route('login'), [
            'email' => null,
            'password' => 'password',
            'recaptcha_token' => true,
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
        
        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => null,
            'recaptcha_token' => true,
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
        $response = $this->post(route('login'), [
            'email' => 'test@example.com',
            'password' => 'password',
            'recaptcha_token' => true,
        ]);

        $response->assertSessionHasErrors(['email']);
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

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'let me in',
            'recaptcha_token' => true,
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /**
     * Test login authentication
     * 
     * @return void
     */
    public function testLoginAuthenticationWithRememberMe()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $this->assertDatabaseHas($user->getTable(), $user->toArray());

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password',
            'recaptcha_token' => true,
            'remember' => 'on',
        ]);

        $this->assertAuthenticatedAs($user);
        $this->assertNotNull($user->remember_token);
        $response->assertRedirect(route('dashboard'));
    }

    /**
     * Test logout of authenticated user
     * 
     * @return void
     */
    public function testLogout()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $this->assertDatabaseHas($user->getTable(), $user->toArray());

        $response = $this->actingAs($user)->post(route('logout'));

        $response->assertRedirect(route('landing'));
        $this->assertGuest();
    }
}
