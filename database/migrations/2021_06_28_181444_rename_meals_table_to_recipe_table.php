<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameMealsTableToRecipeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('meals', 'recipes');
        Schema::rename('allergen_meal', 'allergen_recipe');
        Schema::rename('ingredient_meal', 'ingredient_recipe');
        Schema::rename('meal_menu', 'menu_recipe');

        Schema::table('menu_recipe', function (Blueprint $table) {
            $table->renameColumn('meal_id', 'recipe_id');
        });

        Schema::table('allergen_recipe', function (Blueprint $table) {
            $table->renameColumn('meal_id', 'recipe_id');
        });

        Schema::table('ingredient_recipe', function (Blueprint $table) {
            $table->renameColumn('meal_id', 'recipe_id');
        });

        Schema::table('likes', function (Blueprint $table) {
            $table->renameColumn('meal_id', 'recipe_id');
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->renameColumn('meal_id', 'recipe_id');
        });

        Schema::table('ratings', function (Blueprint $table) {
            $table->renameColumn('meal_id', 'recipe_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('recipes');
        Schema::dropIfExists('allergen_recipe');
        Schema::dropIfExists('ingredient_recipe');
    }
}
