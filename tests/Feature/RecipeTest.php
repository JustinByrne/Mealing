<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Recipe;
use Livewire\Livewire;
use App\Models\Allergen;
use App\Models\Category;
use App\Models\Ingredient;
use App\Http\Livewire\Comments;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecipeTest extends TestCase
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
     * test the index of recipes.
     * 
     * @return void
     */
    public function testCanAccessMyRecipesPage()
    {
        $this->withoutExceptionHandling();
        $this->user->givePermissionTo('meal_access');
        
        $response = $this->actingAs($this->user)->get(route('recipes.index'));

        $response->assertOk();
    }

    /**
     * test the index of recipes without permission.
     * 
     * @return void
     */
    public function testDeniedUnauthorisedAccessToMyRecipesWhenNotLoggedIn()
    {
        $response = $this->get(route('recipes.index'));

        $response->assertRedirect(route('login'));
    }

    /**
     * test recipe create form.
     * 
     * @return void
     */
    public function testCanAccessCreateRecipeFormPage()
    {
        $this->withoutExceptionHandling();
        $this->user->givePermissionTo('meal_create');

        $recipe = Recipe::factory()->create();

        $response = $this->actingAs($this->user)
                    ->get(route('recipes.create', [$recipe->slug]))
                    ->assertSeeLivewire('recipes.create');


        $response->assertOk();
        $response->assertViewIs('recipes.create');
    }

    /**
     * test recipe create form without permission.
     * 
     * @return void
     */
    public function testDeniedUnauthorisedAccessToCreateRecipeFormWhenNotLoggedIn()
    {
        $recipe = Recipe::factory()->create();

        $response = $this->get(route('recipes.create', [$recipe->slug]));

        $response->assertRedirect(route('login'));
    }
    
    /**
     * Test create new recipe.
     *
     * @return void
     */
    public function testCanCreateANewRecipe()
    {
        $this->withoutExceptionHandling();
        $this->user->givePermissionTo('meal_create');

        Ingredient::factory()->count(3)->create();

        $instructions = $this->faker->paragraph;
        $ingredients = Ingredient::pluck('id')->take(5)->toArray();
        $quantities = array('1kg', '2tbsp', '1 cup');
        $allergens = array('1' => 'no', '2' => 'may', '3' => 'yes');
        $category = Category::inRandomOrder()->first()->id;
        
        $response = $this->actingAs($this->user)->post(route('recipes.store'), [
            'name' => $this->faker->name,
            'servings' => $this->faker->randomDigitNotNull,
            'adults' => $this->faker->boolean,
            'kids' => $this->faker->boolean,
            'timing' => $this->faker->randomDigitNotNull,
            'category_id' => $category,
            'instruction' => $instructions,
            'quantities' => $quantities,
            'ingredients' => $ingredients,
            'allergens' => $allergens
        ]);

        $recipe = Recipe::first();

        $this->assertDatabaseCount(Recipe::getTableName(), 1);
        $this->assertDatabaseHas(Recipe::getTableName(), [
            'instruction' => $instructions,
            'category_id' => $category,
        ]);

        foreach($ingredients as $ingredient)    {
            $this->assertDatabaseHas('ingredient_recipe', [
                'ingredient_id' => $ingredient,
                'recipe_id' => $recipe->id,
            ]);
        }

        foreach($allergens as $id => $level)    {
            if($level != 'no')  {
                $this->assertDatabaseHas('allergen_recipe', [
                    'allergen_id' => $id,
                    'recipe_id' => $recipe->id,
                    'level' => $level
                ]);
            }
        }

        $response->assertRedirect($recipe->path());
    }

    /**
     * Test create new recipe with name null.
     *
     * @return void
     */
    public function testErrorWhenCreatingANewRecipeWithoutAName()
    {
        $this->user->givePermissionTo('meal_create');
        
        $response = $this->actingAs($this->user)
            ->post(route('recipes.store'), [
                'name' => null,
                'servings' => $this->faker->randomDigitNotNull,
                'adults' => $this->faker->boolean,
                'kids' => $this->faker->boolean,
                'timing' => $this->faker->randomDigitNotNull,
        ]);

        $response->assertSessionHasErrors(['name']);
    }

    /**
     * Test create new recipe with serving null.
     *
     * @return void
     */
    public function testErrorWhenCreatingANewRecipeWithoutAServing()
    {
        $this->user->givePermissionTo('meal_create');
        
        $response = $this->actingAs($this->user)
            ->post(route('recipes.store'), [
                'name' => $this->faker->name,
                'servings' => null,
                'adults' => $this->faker->boolean,
                'kids' => $this->faker->boolean,
                'timing' => $this->faker->randomDigitNotNull,
        ]);

        $response->assertSessionHasErrors(['servings']);
    }

    /**
     * Test create new recipe with timing null.
     *
     * @return void
     */
    public function testErrorWhenCreatingANewRecipeWithoutTiming()
    {
        $this->user->givePermissionTo('meal_create');
        
        $response = $this->actingAs($this->user)
            ->post(route('recipes.store'), [
                'name' => $this->faker->name,
                'servings' => $this->faker->randomDigitNotNull,
                'adults' => $this->faker->boolean,
                'kids' => $this->faker->boolean,
                'timing' => null,
        ]);

        $response->assertSessionHasErrors(['timing']);
    }

    /**
     * Test create new recipe without permission.
     * 
     * @return void
     */
    public function testDeniedAccessToCreateANewRecipeWithoutPermission()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('recipes.store'), [
                'name' => $this->faker->name,
                'servings' => $this->faker->randomDigitNotNull,
                'adults' => $this->faker->boolean,
                'kids' => $this->faker->boolean,
                'timing' => $this->faker->randomDigitNotNull,
        ]);

        $response->assertForbidden();
    }

    /**
     * test a recipe can be shown.
     * 
     * @return void
     */
    public function testCanAccessIndividualRecipePage()
    {
        $this->withoutExceptionHandling();
        $this->user->givePermissionTo('meal_show');

        $recipe = Recipe::factory()->create();

        $response = $this->actingAs($this->user)->get($recipe->path());

        $response->assertOk();
        $response->assertSeeLivewire('comments');
    }

    /**
     * test a recipe can be shown without permission.
     * 
     * @return void
     */
    public function testDeniedAccessToViewIndividualRecipeWithoutPermission()
    {
        $user = User::factory()->create();
        $recipe = Recipe::factory()->create();

        $response = $this->actingAs($user)->get($recipe->path());

        $response->assertForbidden();
    }

    /**
     * test adding a comment
     * 
     * @return void
     */
    public function testCanAddACommentToRecipe()
    {
        $this->withoutExceptionHandling();

        $recipe = Recipe::factory()->create();
        
        Livewire::actingAs($this->user)
            ->test(Comments::class, ['recipe' => $recipe])
            ->set('comment', 'foo')
            ->call('addComment');
        
        $this->assertTrue(!is_null($recipe->refresh()->comments->firstWhere('comment', 'foo')));
    }

    /**
     * test adding a comment with a null comment
     * 
     * @return void
     */
    public function testErrorWhenAddingACommentToRecipeWithoutAComment()
    {
        $recipe = Recipe::factory()->create();
        
        Livewire::actingAs($this->user)
            ->test(Comments::class, ['recipe' => $recipe])
            ->set('comment', null)
            ->call('addComment')
            ->assertHasErrors(['comment' => 'required']);
    }

    /**
     * test recipe edit form.
     * 
     * @return void
     */
    public function testCanAccessEditRecipeFormPage()
    {
        $this->withoutExceptionHandling();
        $this->user->givePermissionTo('meal_edit');

        $recipe = Recipe::factory()->create();

        $response = $this->actingAs($this->user)
                    ->get(route('recipes.edit', [$recipe->slug]))
                    ->assertSeeLivewire('recipes.create');

        $response->assertOk();
    }

    /**
     * test recipe edit form without permission.
     * 
     * @return void
     */
    public function testDeniedUnauthorisedAccessToEditRecipeFormWhenNotLoggedIn()
    {
        $recipe = Recipe::factory()->create();

        $response = $this->get(route('recipes.edit', [$recipe->slug]));

        $response->assertRedirect(route('login'));
    }

    /**
     * Test a recipe can be updated.
     * 
     * @return void
     */
    public function testCanUpdateARecipesDetails()
    {
        $this->withoutExceptionHandling();
        $this->user->givePermissionTo('meal_edit');
        
        $recipe = Recipe::factory()->create();
        $recipe->allergens()->attach(Allergen::find(1), ['level' => 'no']);
        $allergens = array('1' => 'yes', '2' => 'no', '3' => 'may');
        $category = Category::inRandomOrder()->first()->id;

        // new data
        $data = [
            'name' => $this->faker->name,
            'servings' => $this->faker->randomDigitNotNull,
            'adults' => $this->faker->boolean,
            'kids' => $this->faker->boolean,
            'timing' => $this->faker->randomDigitNotNull,
            'instruction' => $this->faker->paragraph,
            'category_id' => $category,
            'allergens' => $allergens,
        ];

        $response = $this->actingAs($this->user)->patch(route('recipes.update', $recipe), $data);
        $recipe->refresh();

        $this->assertDatabaseHas(Recipe::getTableName(), [
            'name' => $data['name'],
            'servings' => $data['servings'],
            'adults' => $data['adults'],
            'kids' => $data['kids'],
            'timing' => $data['timing'],
            'instruction' => $data['instruction'],
            'category_id' => $category,
        ]);

        foreach($allergens as $id => $level)    {
            if($level != 'no')  {
                $this->assertDatabaseHas('allergen_recipe', [
                    'allergen_id' => $id,
                    'recipe_id' => $recipe->id,
                    'level' => $level
                ]);
            }
        }
        $response->assertRedirect($recipe->path());
    }

    /**
     * Test updating recipe without permission.
     * 
     * @return void
     */
    public function testDeniedAccessWhenUpdatingARecipeWithoutPermission()
    {
        $user = User::factory()->create();
        $recipe = Recipe::factory()->create();

        // new data
        $name = $this->faker->name;
        $serving = $this->faker->randomDigitNotNull;
        $adults = $this->faker->boolean;
        $kids = $this->faker->boolean;
        $timing = $this->faker->randomDigitNotNull;

        $response = $this->actingAs($user)
            ->patch(route('recipes.update', [$recipe->slug]), [
                'name' => $name,
                'servings' => $serving,
                'adults' => $adults,
                'kids' => $kids,
                'timing' => $timing,
        ]);

        $response->assertForbidden();
    }

    /**
     * Test that a recipe can be deleted.
     * 
     * @return void
     */
    public function testCanDeleteARecipe()
    {
        $this->withoutExceptionHandling();
        $this->user->givePermissionTo('meal_delete');
        
        $recipe = Recipe::factory()->create();

        $this->assertDatabaseCount($recipe->getTable(), 1);

        $this->actingAs($this->user)->delete(route('recipes.destroy', [$recipe->slug]));

        $this->assertSoftDeleted($recipe);
    }

    /**
     * Test recipe can be deleted without permission.
     * 
     * @return void
     */
    public function testDeniedAccessDeletingARecipeWithoutPermission()
    {
        $user = User::factory()->create();
        $recipe = Recipe::factory()->create();

        $this->assertDatabaseCount($recipe->getTable(), 1);

        $response = $this->actingAs($user)->delete(route('recipes.destroy', [$recipe->slug]));

        $response->assertForbidden();
    }
}
