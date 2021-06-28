<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allergen extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'icon'
    ];

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class);
    }

    public static function getTableName(): string
    {
        return (new self())->getTable();
    }
}
