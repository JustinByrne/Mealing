<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Serving extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quantity',
    ];

    /**
     * Get the meals for the serving.
     */
    public function meals()
    {
        return $this->hasMany('App\Models\Meal');
    }

    /**
     * Get the url path for the Meal
     * 
     * @return Illuminate\Support\Facades\Route;
     */
    public function path()
    {
        return route('servings.show', [$this->id]);
    }
}
