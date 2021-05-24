<?php

namespace App\Models;

use App\Models\Meal;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory, SoftDeletes;

    public function user()
    {
        $this->belongsTo(User::class);
    }

    public function meals()
    {
        $this->belongsToMany(Meal::class)->withPivot('date');
    }
}
