<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
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
        'servings',
        'adults',
        'kids',
        'timing',
    ];

    /**
     * The ingredients that belong to the meal.
     */
    public function ingredients()
    {
        return $this->belongsToMany('App\Models\Ingredient')->withPivot('quantity');
    }

    /**
     * The User that owns the Ingredient
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The ratings that belong to the meal
     */
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * The comments that belong to the meal
     */
    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'DESC');
    }


    /**
     * Get the url path for the Meal
     * 
     * @return Illuminate\Support\Facades\Route;
     */
    public function path()
    {
        return route('meals.show', [$this->slug]);
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Creating the slug from the name
     */
    public function setNameAttribute($value)
    {
        if ($value)  {
            $this->attributes['name'] = $value;
            $this->attributes['slug'] = Str::slug($value, '-');
        }
    }

    /**
     * Change the minutes into a human readable format
     * 
     * @return \Carbon\CarbonInterval
     */
    public function getReadableTimingAttribute()
    {
        return \Carbon\CarbonInterval::minutes($this->timing)->cascade()->forHumans();
    }

    /**
     * Check if user already has a comment
     * 
     * @return boolean
     */
    public function hasCommentsFromUser()
    {
        return !is_null($this->comments->firstWhere('user_id', \Auth::Id()));
    }
}
