<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ingredient extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The User that owns the Ingredient
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The meals that belong to the ingredient.
     */
    public function meals()
    {
        return $this->belongsToMany('App\Models\Meal');
    }

    /**
     * Get the url path for the Timing
     * 
     * @return Illuminate\Support\Facades\Route;
     */
    public function path()
    {
        return route('ingredients.show', [$this->id]);
    }
}
