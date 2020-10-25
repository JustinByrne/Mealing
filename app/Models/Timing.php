<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timing extends Model
{
    use HasFactory;

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
}
