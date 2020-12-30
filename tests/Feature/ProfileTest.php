<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileTest extends TestCase
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
     * test the profile page opens for the user.
     *
     * @return void
     */
    public function testProfilePage()
    {
        $this->withoutExceptionHandling();
        
        $response = $this->actingAs($this->user)->get('/user/profile');

        $this->assertAuthenticated($guard = null);
        $response->assertOk();
        $response->assertSeeText($this->user->getFullname(), $escaped = true);
    }

    /**
     * test the settings page is a 404
     * 
     * @return void
     */
    public function testSettingsPageDoesNotExist()
    {
        $response = $this->actingAs($this->user)->get('/user/profile/settings');

        $response->assertNotFound();
    }

    /**
     * test the account settings page
     * 
     * @return void
     */
    public function testAccountSettingsPage()
    {
        $this->withoutExceptionHandling();
        
        $response = $this->actingAs($this->user)->get('/user/profile/settings/account');

        $response->assertOk();
    }

    /**
     * test that the user can update their profile details
     * 
     * @return void
     */
    public function testUserCanUpdateTheirNameAndEmail()
    {
        $this->withoutExceptionHandling();

        $response = $this->actingAs($this->user)->patch('/user/profile/settings/account', [
            'name' => 'foo bar',
            'email' => 'foo@gmail.com'
        ]);

        $this->user->refresh();

        $this->assertDatabaseHas('users', [
            'name' => 'foo bar',
            'email' => 'foo@gmail.com',
            'email_verified_at' => null
        ]);
        $response->assertRedirect('/user/profile/settings/account');
        $response->assertSessionHas('profileStatus', 'Account Successfully Updated');
    }

    /**
     * test that the user can update their profile details
     * 
     * @return void
     */
    public function testUserCanUpdateTheirName()
    {
        $this->withoutExceptionHandling();

        $response = $this->actingAs($this->user)->patch('/user/profile/settings/account', [
            'name' => 'foo bar',
            'email' => $this->user->email
        ]);

        $this->user->refresh();

        $this->assertDatabaseHas('users', [
            'name' => 'foo bar',
            'email' => $this->user->email
        ]);
        $response->assertRedirect('/user/profile/settings/account');
        $response->assertSessionHas('profileStatus', 'Account Successfully Updated');
    }

    /**
     * test that the user can update their profile details
     * 
     * @return void
     */
    public function testUserCanUpdateTheirEmail()
    {
        $this->withoutExceptionHandling();

        $response = $this->actingAs($this->user)->patch('/user/profile/settings/account', [
            'name' => $this->user->name,
            'email' => 'email@gmail.com'
        ]);

        $this->user->refresh();

        $this->assertDatabaseHas('users', [
            'name' => $this->user->name,
            'email' => 'email@gmail.com',
            'email_verified_at' => null
        ]);
        $response->assertRedirect('/user/profile/settings/account');
        $response->assertSessionHas('profileStatus', 'Account Successfully Updated');
    }

    /**
     * test that an error happens if no name
     * 
     * @return void
     */
    public function testErrorWhenUpdatingProfileWithNoName()
    {
        $response = $this->actingAs($this->user)->patch('/user/profile/settings/account', [
            'name' => null,
            'email' => 'foo@bar.com'
        ]);

        $response->assertSessionHasErrors(['name']);
    }

    /**
     * test that an error happens if no email
     * 
     * @return void
     */
    public function testErrorWhenUpdatingProfileWithNoEmail()
    {
        $response = $this->actingAs($this->user)->patch('/user/profile/settings/account', [
            'name' => 'foo',
            'email' => null
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /**
     * test the user can change their password
     * 
     * @return void
     */
    public function testUserCanChangeTheirPassword()
    {
        $this->withoutExceptionHandling();
        
        $response = $this->actingAs($this->user)->post('/user/profile/settings/account/password', [
            'current' => 'password',
            'password' => 'Passw0rd!',
            'password_confirmation' => 'Passw0rd!'
        ]);

        $response->assertRedirect('/user/profile/settings/account');
        $response->assertSessionHas('passwordStatus', 'Password Changed Successfully');
        $this->assertTrue(Hash::check('Passw0rd!', $this->user->password));
    }

    /**
     * test that an error happens if no current password
     * 
     * @return void
     */
    public function testErrorWhenChangingPasswordWithNoCurrentPassword()
    {
        $response = $this->actingAs($this->user)->post('/user/profile/settings/account/password', [
            'current' => null,
            'password' => 'Passw0rd!',
            'password_confirmation' => 'Passw0rd!'
        ]);

        $response->assertSessionHasErrors(['current']);
    }

    /**
     * test that an error happens if incorrect password
     * 
     * @return void
     */
    public function testErrorWhenChangingPasswordWithIncorrectPassword()
    {
        $response = $this->actingAs($this->user)->post('/user/profile/settings/account/password', [
            'current' => 'Sandwich',
            'password' => 'Passw0rd!',
            'password_confirmation' => 'Passw0rd!'
        ]);

        $response->assertSessionHasErrors(['current']);
    }

    /**
     * test that an error happens if no new password
     * 
     * @return void
     */
    public function testErrorWhenChangingPasswordWithNoNewPassword()
    {
        $response = $this->actingAs($this->user)->post('/user/profile/settings/account/password', [
            'current' => 'password',
            'password' => null,
            'password_confirmation' => 'Passw0rd!'
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    /**
     * test that an error happens if not confirming password
     * 
     * @return void
     */
    public function testErrorWhenChangingPasswordWithNoPasswordConfirmation()
    {
        $response = $this->actingAs($this->user)->post('/user/profile/settings/account/password', [
            'current' => 'password',
            'password' => 'Passw0rd!',
            'password_confirmation' => null
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    /**
     * test that an error happens if confrmed password does not match
     * 
     * @return void
     */
    public function testErrorWhenChangingPasswordWhenNewPasswordAndConfirmedDontMatch()
    {
        $response = $this->actingAs($this->user)->post('/user/profile/settings/account/password', [
            'current' => 'password',
            'password' => 'Passw0rd!',
            'password_confirmation' => 'Passw0rd!!'
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    /**
     * test the settings security page
     * 
     * @return void
     */
    public function testSecuritySettingsPage()
    {
        $this->withoutExceptionHandling();
        
        $response = $this->actingAs($this->user)->get('/user/profile/settings/security');

        $response->assertOk();
    }
}
