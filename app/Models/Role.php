<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description'
    ];

    /**
     * The users that belong to the role.
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Get the url path for the Timing
     */
    public function path()
    {
        return route('admin.roles.show', [$this->id]);
    }

    /**
     * Get the permissions that belong to the role.
     * 
     * @return Illuminate\Support\Facades\Route;
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
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
