<?php

namespace App\Models;

use App\Models\Menu;
use Carbon\CarbonInterval;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mehradsadeghi\FilterQueryString\FilterQueryString;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Recipe extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia, FilterQueryString;

    protected $fillable = [
        'name',
        'servings',
        'adults',
        'kids',
        'timing',
        'instruction'
    ];

    protected $filters = [
        'sort',
        'between'
    ];

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class)->withPivot('quantity');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'DESC');
    }

    public function allergens()
    {
        return $this->belongsToMany(Allergen::class)->withPivot('level');
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class)->withPivot('date');
    }

    public function likedUser()
    {
        return $this->belongsToMany(User::class, 'likes');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function path(): string
    {
        return route('recipes.show', [$this->slug]);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function setNameAttribute($value): void
    {
        if ($value)  {
            $this->attributes['name'] = $value;
            $this->attributes['slug'] = Str::slug($value, '-');
        }
    }

    public function getReadableTimingAttribute(): CarbonInterval
    {
        return \Carbon\CarbonInterval::minutes($this->timing)->cascade()->forHumans();
    }

    public function hasCommentsFromUser(): bool
    {
        return !is_null($this->comments->firstWhere('user_id', \Auth::Id()));
    }

    public function getAvgRatingAttribute(): ?float
    {
        return $this->ratings->avg('score');
    }

    public static function getTableName(): string
    {
        return (new self())->getTable();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
              ->width(368)
              ->height(276)
              ->sharpen(10);
    }
}
