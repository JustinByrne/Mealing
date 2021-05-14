<?php

namespace App\Models;

use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mehradsadeghi\FilterQueryString\FilterQueryString;

class Meal extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia, FilterQueryString;

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
        'instruction'
    ];

    /**
     * The attributes that are filterable or filtable options
     * 
     * @var array
     */
    protected $filters = [
        'sort',
    ];

    /**
     * The ingredients that belong to the meal.
     */
    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class)->withPivot('quantity');
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
     * The allergens that belong to the meal.
     */
    public function allergens()
    {
        return $this->belongsToMany(Allergen::class)->withPivot('level');
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

    /**
     * Getting the average rating for a meal
     * 
     * @return float
     */
    public function getAvgRatingAttribute()
    {
        return $this->ratings->avg('score');
    }

    /**
     * Getting the table name
     * 
     * @return string
     */
    public static function getTableName()
    {
        return (new self())->getTable();
    }
}
