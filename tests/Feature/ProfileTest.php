<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

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
    public function testUserCanUpdateTheirNameOrEmail()
    {
        $this->withoutExceptionHandling();

        $response = $this->actingAs($this->user)->patch('/user/profile/settings/account', [
            'name' => 'foo bar',
            'email' => 'foo@gmail.com'
        ]);

        $this->user->refresh();

        $this->assertDatabaseHas('users', [
            'name' => 'foo bar',
            'email' => 'foo@gmail.com'
        ]);
        $response->assertRedirect('/user/profile/settings/account');
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
