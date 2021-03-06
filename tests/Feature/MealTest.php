<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Meal;
use App\Models\User;
use Livewire\Livewire;
use App\Models\Allergen;
use App\Models\Ingredient;
use App\Http\Livewire\Comments;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MealTest extends TestCase
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
     * test the index of meals.
     * 
     * @return void
     */
    public function testCanAccessMyMealsPage()
    {
        $this->withoutExceptionHandling();
        $this->user->givePermissionTo('meal_access');
        
        $response = $this->actingAs($this->user)->get(route('meals.index'));

        $response->assertOk();
    }

    /**
     * test the all meals function.
     * 
     * @return void
     */
    public function testCanAccessAllMealsPage()
    {
        $this->withoutExceptionHandling();
        $this->user->givePermissionTo('meal_access');
        
        $response = $this->actingAs($this->user)->get(route('meals.all'));

        $response->assertOk();
    }

    /**
     * test the index of meals without permission.
     * 
     * @return void
     */
    public function testDeniedUnauthorisedAccessToMyMealsWhenNotLoggedIn()
    {
        $response = $this->get(route('meals.index'));

        $response->assertRedirect(route('login'));
    }

    /**
     * test meal create form.
     * 
     * @return void
     */
    public function testCanAccessCreateMealFormPage()
    {
        $this->withoutExceptionHandling();
        $this->user->givePermissionTo('meal_create');

        $meal = Meal::factory()->create();

        $response = $this->actingAs($this->user)
                    ->get(route('meals.create', [$meal->slug]))
                    ->assertSeeLivewire('meals.create');


        $response->assertOk();
        $response->assertViewIs('meals.create');
    }

    /**
     * test meal create form without permission.
     * 
     * @return void
     */
    public function testDeniedUnauthorisedAccessToCreateMealFormWhenNotLoggedIn()
    {
        $meal = Meal::factory()->create();

        $response = $this->get(route('meals.create', [$meal->slug]));

        $response->assertRedirect(route('login'));
    }
    
    /**
     * Test create new meal.
     *
     * @return void
     */
    public function testCanCreateANewMeal()
    {
        $this->withoutExceptionHandling();
        $this->user->givePermissionTo('meal_create');

        Ingredient::factory()->count(3)->create();

        $instructions = $this->faker->paragraph;
        $ingredients = Ingredient::pluck('id')->take(5)->toArray();
        $quantities = array('1kg', '2tbsp', '1 cup');
        $allergens = array('1' => 'no', '2' => 'may', '3' => 'yes');
        
        $response = $this->actingAs($this->user)->post(route('meals.store'), [
            'name' => $this->faker->name,
            'servings' => $this->faker->randomDigitNotNull,
            'adults' => $this->faker->boolean,
            'kids' => $this->faker->boolean,
            'timing' => $this->faker->randomDigitNotNull,
            'instruction' => $instructions,
            'quantities' => $quantities,
            'ingredients' => $ingredients,
            'allergens' => $allergens
        ]);

        $meal = Meal::first();

        $this->assertDatabaseCount(Meal::getTableName(), 1);
        $this->assertDatabaseHas(Meal::getTableName(), [
            'instruction' => $instructions,
        ]);

        foreach($ingredients as $ingredient)    {
            $this->assertDatabaseHas('ingredient_meal', [
                'ingredient_id' => $ingredient,
                'meal_id' => $meal->id,
            ]);
        }

        foreach($allergens as $id => $level)    {
            if($level != 'no')  {
                $this->assertDatabaseHas('allergen_meal', [
                    'allergen_id' => $id,
                    'meal_id' => $meal->id,
                    'level' => $level
                ]);
            }
        }

        $response->assertRedirect($meal->path());
    }

    /**
     * Test create new meal with name null.
     *
     * @return void
     */
    public function testErrorWhenCreatingANewMealWithoutAName()
    {
        $this->user->givePermissionTo('meal_create');
        
        $response = $this->actingAs($this->user)
            ->post(route('meals.store'), [
                'name' => null,
                'servings' => $this->faker->randomDigitNotNull,
                'adults' => $this->faker->boolean,
                'kids' => $this->faker->boolean,
                'timing' => $this->faker->randomDigitNotNull,
        ]);

        $response->assertSessionHasErrors(['name']);
    }

    /**
     * Test create new meal with serving null.
     *
     * @return void
     */
    public function testErrorWhenCreatingANewMealWithoutAServing()
    {
        $this->user->givePermissionTo('meal_create');
        
        $response = $this->actingAs($this->user)
            ->post(route('meals.store'), [
                'name' => $this->faker->name,
                'servings' => null,
                'adults' => $this->faker->boolean,
                'kids' => $this->faker->boolean,
                'timing' => $this->faker->randomDigitNotNull,
        ]);

        $response->assertSessionHasErrors(['servings']);
    }

    /**
     * Test create new meal with timing null.
     *
     * @return void
     */
    public function testErrorWhenCreatingANewMealWithoutTiming()
    {
        $this->user->givePermissionTo('meal_create');
        
        $response = $this->actingAs($this->user)
            ->post(route('meals.store'), [
                'name' => $this->faker->name,
                'servings' => $this->faker->randomDigitNotNull,
                'adults' => $this->faker->boolean,
                'kids' => $this->faker->boolean,
                'timing' => null,
        ]);

        $response->assertSessionHasErrors(['timing']);
    }

    /**
     * Test create new meal without permission.
     * 
     * @return void
     */
    public function testDeniedAccessToCreateANewMealWithoutPermission()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('meals.store'), [
                'name' => $this->faker->name,
                'servings' => $this->faker->randomDigitNotNull,
                'adults' => $this->faker->boolean,
                'kids' => $this->faker->boolean,
                'timing' => $this->faker->randomDigitNotNull,
        ]);

        $response->assertForbidden();
    }

    /**
     * test a meal can be shown.
     * 
     * @return void
     */
    public function testCanAccessIndividualMealPage()
    {
        $this->withoutExceptionHandling();
        $this->user->givePermissionTo('meal_show');

        $meal = Meal::factory()->create();

        $response = $this->actingAs($this->user)->get($meal->path());

        $response->assertOk();
        $response->assertSeeLivewire('comments');
    }

    /**
     * test a meal can be shown without permission.
     * 
     * @return void
     */
    public function testDeniedAccessToViewIndividualMealWithoutPermission()
    {
        $user = User::factory()->create();
        $meal = Meal::factory()->create();

        $response = $this->actingAs($user)->get($meal->path());

        $response->assertForbidden();
    }

    /**
     * test adding a comment
     * 
     * @return void
     */
    public function testCanAddACommentToMeal()
    {
        $this->withoutExceptionHandling();

        $meal = Meal::factory()->create();
        
        Livewire::actingAs($this->user)
            ->test(Comments::class, ['meal' => $meal])
            ->set('comment', 'foo')
            ->call('addComment');
        
        $this->assertTrue(!is_null($meal->refresh()->comments->firstWhere('comment', 'foo')));
    }

    /**
     * test adding a comment with a null comment
     * 
     * @return void
     */
    public function testErrorWhenAddingACommentToMealWithoutAComment()
    {
        $meal = Meal::factory()->create();
        
        Livewire::actingAs($this->user)
            ->test(Comments::class, ['meal' => $meal])
            ->set('comment', null)
            ->call('addComment')
            ->assertHasErrors(['comment' => 'required']);
    }

    /**
     * test meal edit form.
     * 
     * @return void
     */
    public function testCanAccessEditMealFormPage()
    {
        $this->withoutExceptionHandling();
        $this->user->givePermissionTo('meal_edit');

        $meal = Meal::factory()->create();

        $response = $this->actingAs($this->user)
                    ->get(route('meals.edit', [$meal->slug]))
                    ->assertSeeLivewire('meals.create');

        $response->assertOk();
    }

    /**
     * test meal edit form without permission.
     * 
     * @return void
     */
    public function testDeniedUnauthorisedAccessToEditMealFormWhenNotLoggedIn()
    {
        $meal = Meal::factory()->create();

        $response = $this->get(route('meals.edit', [$meal->slug]));

        $response->assertRedirect(route('login'));
    }

    /**
     * Test a meal can be updated.
     * 
     * @return void
     */
    public function testCanUpdateAMealsDetails()
    {
        $this->withoutExceptionHandling();
        $this->user->givePermissionTo('meal_edit');
        
        $meal = Meal::factory()->create();
        $meal->allergens()->attach(Allergen::find(1), ['level' => 'no']);
        $allergens = array('1' => 'yes', '2' => 'no', '3' => 'may');

        // new data
        $data = [
            'name' => $this->faker->name,
            'servings' => $this->faker->randomDigitNotNull,
            'adults' => $this->faker->boolean,
            'kids' => $this->faker->boolean,
            'timing' => $this->faker->randomDigitNotNull,
            'instruction' => $this->faker->paragraph,
            'allergens' => $allergens,
        ];

        $response = $this->actingAs($this->user)->patch(route('meals.update', $meal), $data);
        $meal->refresh();

        $this->assertDatabaseHas(Meal::getTableName(), [
            'name' => $data['name'],
            'servings' => $data['servings'],
            'adults' => $data['adults'],
            'kids' => $data['kids'],
            'timing' => $data['timing'],
            'instruction' => $data['instruction'],
        ]);

        foreach($allergens as $id => $level)    {
            if($level != 'no')  {
                $this->assertDatabaseHas('allergen_meal', [
                    'allergen_id' => $id,
                    'meal_id' => $meal->id,
                    'level' => $level
                ]);
            }
        }
        $response->assertRedirect($meal->path());
    }

    /**
     * Test updating meal without permission.
     * 
     * @return void
     */
    public function testDeniedAccessWhenUpdatingAMealWithoutPermission()
    {
        $user = User::factory()->create();
        $meal = Meal::factory()->create();

        // new data
        $name = $this->faker->name;
        $serving = $this->faker->randomDigitNotNull;
        $adults = $this->faker->boolean;
        $kids = $this->faker->boolean;
        $timing = $this->faker->randomDigitNotNull;

        $response = $this->actingAs($user)
            ->patch(route('meals.update', [$meal->slug]), [
                'name' => $name,
                'servings' => $serving,
                'adults' => $adults,
                'kids' => $kids,
                'timing' => $timing,
        ]);

        $response->assertForbidden();
    }

    /**
     * Test that a meal can be deleted.
     * 
     * @return void
     */
    public function testCanDeleteAMeal()
    {
        $this->withoutExceptionHandling();
        $this->user->givePermissionTo('meal_delete');
        
        $meal = Meal::factory()->create();

        $this->assertDatabaseCount($meal->getTable(), 1);

        $this->actingAs($this->user)->delete(route('meals.destroy', [$meal->slug]));

        $this->assertSoftDeleted($meal);
    }

    /**
     * Test meal can be deleted without permission.
     * 
     * @return void
     */
    public function testDeniedAccessDeletingAMealWithoutPermission()
    {
        $user = User::factory()->create();
        $meal = Meal::factory()->create();

        $this->assertDatabaseCount($meal->getTable(), 1);

        $response = $this->actingAs($user)->delete(route('meals.destroy', [$meal->slug]));

        $response->assertForbidden();
    }
}
