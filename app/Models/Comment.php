<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'comment',
        'user_id',
    ];

    /**
     * The User that owns the Comment
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Changing the created at date to human readable
     * 
     * @return \Carbon\CarbonInterval
     */
    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('j<\s\up>S</\s\up> F Y');
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
