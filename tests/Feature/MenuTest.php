<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MenuTest extends TestCase
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
     * test the menu index page
     * 
     * @return void
     */
    public function testAllowMenuIndexPage()
    {
        $this->withoutExceptionHandling();
        $this->user->givePermissionTo('menu_access');

        $response = $this->actingAs($this->user)->get(route('menu.index'));

        $response->assertOk();
    }

    /**
     * test the menu index page not logged in
     * 
     * @return void
     */
    public function testDenyMenuIndexPageWhenNotLoggedIn()
    {
        $response = $this->get(route('menu.index'));

        $this->assertGuest($guard = null);
        $response->assertRedirect(route('login'));
    }

    /**
     * test the menu index page without permission
     * 
     * @return void
     */
    public function testDenyMenuIndexPageWithoutPermission()
    {
        $response = $this->actingAs($this->user)->get(route('menu.index'));

        $response->assertForbidden();
    }
}
