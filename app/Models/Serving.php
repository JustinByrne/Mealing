<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serving extends Model
{
    use HasFactory;

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
     */
    public function path()
    {
        return route('servings.show', [$this->id]);
    }
}
