<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /**
     * The User that owns the Comment
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
