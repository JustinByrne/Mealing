<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
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
        return route('ingredients.show', [$this->slug]);
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
            $this->attributes['name'] = ucwords($value);
            $this->attributes['slug'] = Str::slug($value, '-');
        }
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
