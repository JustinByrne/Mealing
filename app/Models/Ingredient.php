<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ingredient extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class);
    }

    public function path(): string
    {
        return route('admin.ingredients.show', [$this->slug]);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function setNameAttribute($value): void
    {
        if ($value)  {
            $this->attributes['name'] = ucwords($value);
            $this->attributes['slug'] = Str::slug($value, '-');
        }
    }

    public static function getTableName(): string
    {
        return (new self())->getTable();
    }
}
