<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Recipe;
use App\Models\Menu;
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

        $response = $this->actingAs($this->user)->get(route('menus.index'));

        $response->assertOk();
    }

    public function testDenyMenuIndexPageWhenNotLoggedIn(): void
    {
        $response = $this->get(route('menus.index'));

        $this->assertGuest($guard = null);
        $response->assertRedirect(route('login'));
    }

    public function testDenyMenuIndexPageWithoutPermission(): void
    {
        $response = $this->actingAs($this->user)->get(route('menus.index'));

        $response->assertForbidden();
    }

    public function testAllowCreateMenuPage(): void
    {
        $this->user->givePermissionTo('menu_create');

        $response = $this->actingAs($this->user)->get(route('menus.create'));

        $response->assertOk();
    }

    public function testDenyMenuCreatePageWhenNotLoggedIn(): void
    {
        $response = $this->get(route('menus.create'));

        $this->assertGuest($guard = null);
        $response->assertRedirect(route('login'));
    }

    public function testDenyMenuCreatePageWithoutPermission(): void
    {
        $response = $this->actingAs($this->user)->get(route('menus.create'));

        $response->assertForbidden();
    }

    public function testAllowCreateANewMenu(): void
    {
        $this->withoutExceptionHandling();
        $this->user->givePermissionTo('menu_create');

        $recipes = [
            'wc' => Carbon::now()->startOfWeek()->format('Y-m-d H:i'),
            'monday' => Recipe::factory()->create()->id,
            'tuesday' => Recipe::factory()->create()->id,
            'wednesday' => Recipe::factory()->create()->id,
            'friday' => Recipe::factory()->create()->id,
            'saturday' => Recipe::factory()->create()->id,
            'sunday' => Recipe::factory()->create()->id,
        ];

        $response = $this->actingAs($this->user)->post(route('menus.store', $recipes));

        $menu = Menu::whereHas('recipes', function ($query) use ($recipes) {
            $query->where('recipe_id', $recipes['monday']);
        })->where('user_id', $this->user->id)->first();

        $this->assertDatabaseHas('menu_recipe', [
            'menu_id' => $menu->id,
            'recipe_id' => $recipes['monday']
        ]);
    }
}
