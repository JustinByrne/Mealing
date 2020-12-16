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
        $adminId = \App\Models\Role::find(1)->id;
        $this->user->roles()->sync([$adminId]);
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

        $response->assertOk();
        $response->assertSeeText($this->user->getFullname(), $escaped = true);
    }

    /**
     * test the settings page is a 404
     * 
     * @return void
     */
    public function testSettingsPage()
    {
        $response = $this->actingAs($this->user)->get('/user/profile/settings');

        $response->assertNotFound();
    }

    /**
     * test the account settings page is a 404
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
