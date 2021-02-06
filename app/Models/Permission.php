<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
    ];

    /**
     * Get the url path for the Meal
     */
    public function path()
    {
        return route('admin.permissions.show', [$this->id]);
    }

    /**
     * Get the roles that belong to the permission
     * 
     * @return Illuminate\Support\Facades\Route;
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
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
