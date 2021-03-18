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
     * allow access to the homepage
     * 
     * @return void
     */
    public function testAllowHomepage()
    {
        $this->withoutExceptionHandling();

        $response = $this->get('/');

        $response->assertOk();
        $response->assertViewIs('landing');
    }

    /**
     * denied access to the homepage
     * 
     * @return void
     */
    public function testDenyHomepageWhenLoggedIn()
    {
        $this->withoutExceptionHandling();

        $response = $this->actingAs($this->user)->get('/');

        $response->assertRedirect('/dashboard');
    }

    /**
     * allow access to the dashboard
     * 
     * @return void
     */
    public function testAllowDashboard()
    {
        $this->withoutExceptionHandling();

        $response = $this->actingAs($this->user)->get('/dashboard');

        $response->assertOk();
        $response->assertViewIs('dashboard');
    }

    /**
     * allow access to the dashboard
     * 
     * @return void
     */
    public function testDeniedDashboardWhenNotLoggedIn()
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect(route('login'));
    }
}
