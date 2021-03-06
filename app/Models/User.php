<?php

namespace App\Models;

use Hash;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, TwoFactorAuthenticatable, SoftDeletes, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // /**
    //  * The roles that belong to the user.
    //  */
    // public function roles()
    // {
    //     return $this->belongsToMany(Role::class);
    // }

    /**
     * The Ingredients that belong to the user
     */
    public function Ingredients()
    {
        return $this->hasMany(Ingredient::class);
    }
    
    /**
     * The Meals that belong to the user
     */
    public function Meals()
    {
        return $this->hasMany(Meal::class);
    }

    /**
     * Getting the path of the individual user
     * 
     * @return Illuminate\Support\Facades\Route;
     */
    public function path()
    {
        return route('admin.users.show', [$this->id]);
    }

    /**
     * 
     */
    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    /**
     * User fullname
     */
    public function getFullName()
    {
        return $this->name;
    }
    
    /**
     * Gravatr image
     */
    public function getAvatar($size = 36)
    {
        return 'https://www.gravatar.com/avatar/' . md5($this->email) . '?s=' . $size;
    }

    /**
     * checking is 2FA is enabled
     * 
     * @return boolean
     */
    public function get2faEnabled()
    {
        return !(is_null($this->two_factor_secret));
    }

    /**
     * Getting the users 2fa recovery keys
     * 
     * @return array
     */
    public function getRecoveryCodes()
    {
        return json_decode(decrypt($this->two_factor_recovery_codes));
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
