<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    /**
     * All meals that belongs to the rating
     */
    public function meal()
    {
        return $this->belongsTo(Meal::class);
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
