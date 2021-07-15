<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public $user;

    protected function setUp(): Void
    {
        parent::setUp();

        $this->seed();
        $this->user = User::factory()->create();
    }

    public function testSearchRequiresAuthentication(): Void
    {
        $response = $this->get(route('search', ['s' => 'foo']));

        $response->assertRedirect(route('login'));
    }
    
    public function testCanSearchForRecipeWithFullRecipeName(): Void
    {
        $this->withoutExceptionHandling();
        Recipe::factory()->count(15)->create();
        $recipe = Recipe::first();

        $response = $this->actingAs($this->user)->get(route('search', ['s' => $recipe->name]));

        $response->assertRedirect(route('recipes.show', $recipe));
    }
    
    public function testCanSearchForRecipeWithPartialRecipeName(): Void
    {
        $this->withoutExceptionHandling();
        Recipe::factory()->count(15)->create();
        $recipe = Recipe::first();

        $response = $this->actingAs($this->user)->get(route('search', ['s' => substr($recipe->name, 0, 5)]));

        $response->assertOk();
        $response->assertSeeText($recipe->name);
        $response->assertSee(route('recipes.show', $recipe));
    }

    public function testCanSearchForRecipeWithIngredientName(): Void
    {
        $this->withoutExceptionHandling();
        Recipe::factory()->count(15)->create();
        $recipe = Recipe::first();

        $response = $this->actingAs($this->user)->get(route('search', ['s' => $recipe->ingredients()->first()->name]));

        $response->assertOk();
        $response->assertSeeText($recipe->name);
        $response->assertSee(route('recipes.show', $recipe));
    }
}
