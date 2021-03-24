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
     * setting up a user to be used in all tests
     * 
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

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

        $data = [
            'name' => $this->faker->name,
            'email' => $email,
            'password' => 'password',
            'password_confirmation' => 'password',
            'recaptcha_token' => true,
        ];

        $response = $this->post(route('register'), $data);

        $user = User::where('email', $data['email'])->first();

        $this->assertDatabaseHas('users', [
            'name' => $data['name'],
            'email' => $data['email']
        ]);
        $this->assertTrue($user->hasRole('User'));
        $response->assertRedirect(route('homepage'));
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
        $response->assertRedirect(route('homepage'));
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
        $response->assertRedirect(route('homepage'));
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

        $response->assertRedirect(route('homepage'));
        $this->assertGuest();
    }
}
