<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allergen extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'icon'
    ];

    /**
     * static function to get the table name
     * 
     * @return string
     */
    public static function getTableName()
    {
        return (new self())->getTable();
    }

    /**
     * The meals that belong to the allergen.
     */
    public function meals()
    {
        return $this->belongsToMany(Meal::class);
    }
}
