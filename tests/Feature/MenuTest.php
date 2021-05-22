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

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
        $this->user = User::factory()->create();
    }
    
    public function testAllowMenuIndexPage(): void
    {
        $this->withoutExceptionHandling();
        $this->user->givePermissionTo('menu_access');

        $response = $this->actingAs($this->user)->get(route('menu.index'));

        $response->assertOk();
    }

    public function testDenyMenuIndexPageWhenNotLoggedIn(): void
    {
        $response = $this->get(route('menu.index'));

        $this->assertGuest($guard = null);
        $response->assertRedirect(route('login'));
    }

    public function testDenyMenuIndexPageWithoutPermission(): void
    {
        $response = $this->actingAs($this->user)->get(route('menu.index'));

        $response->assertForbidden();
    }
}
