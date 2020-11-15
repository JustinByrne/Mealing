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
     * Get the url path for the Meal
     * 
     * @return Illuminate\Support\Facades\Route;
     */
    public function path()
    {
        return route('meals.show', [$this->id]);
    }
}
