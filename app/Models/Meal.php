<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meal extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'serving_id',
        'adults',
        'kids',
        'timing_id',
    ];

    /**
     * Get the serving for the meal.
     */
    public function serving()
    {
        return $this->belongsTo('App\Models\Serving');
    }

    /**
     * Get the timing for the meal.
     */
    public function timing()
    {
        return $this->belongsTo('App\Models\Timing');
    }

    /**
     * The ingredients that belong to the meal.
     */
    public function ingredients()
    {
        return $this->belongsToMany('App\Models\Ingredient');
    }

    /**
     * The User that owns the Ingredient
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the url path for the Meal
     * 
     * @return Illuminate\Support\Facades\Route;
     */
    public function path()
    {
        return route('meals.show', [$this->id]);
    }
}
