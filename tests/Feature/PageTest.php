<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PageTest extends TestCase
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
     * test allow access to the homepage
     * 
     * @return void
     */
    public function testAllowHomepage()
    {
        $this->withoutExceptionHandling();

        $response = $this->actingAs($this->user)->get('/');

        $response->assertOk();
        $response->assertViewIs('homepage');
    }

    /**
     * test denied access to the homepage
     * 
     * @return void
     */
    public function testDenyHomepageWhenNotLoggedIn()
    {
        $response = $this->get('/');

        $response->assertRedirect(route('login'));
    }

    /**
     * test allow access to the admin dashboard
     * 
     * @return void
     */
    public function testAllowAdminDashboard()
    {
        $this->withoutExceptionHandling();
        $this->user->givePermissionTo('admin_access');

        $response = $this->actingAs($this->user)->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertViewIs('admin.dashboard');
    }

    /**
     * test denied access to the admin dashboard when not logged in
     * 
     * @return void
     */
    public function testDenyAdminDashboardWhenNotLoggedIn()
    {
        $response = $this->get(route('admin.dashboard'));

        $response->assertRedirect(route('login'));
    }

    /**
     * test denied access to the admin dashboard without permission
     * 
     * @return void
     */
    public function testDeniedAdminDashboardWithoutPermission()
    {
        $response = $this->actingAs($this->user)->get(route('admin.dashboard'));

        $response->assertForbidden();
    }
}
