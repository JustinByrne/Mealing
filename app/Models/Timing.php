<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Timing extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'timeFrame',
    ];


    /**
     * Get the meals for the timing.
     */
    public function meals()
    {
        return $this->hasMany('App\Models\Meal');
    }

    /**
     * Get the url path for the Timing
     * 
     * @return Illuminate\Support\Facades\Route;
     */
    public function path()
    {
        return route('timings.show', [$this->id]);
    }
}
