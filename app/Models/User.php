<?php

namespace App\Models;

use Hash;
use App\Models\Menu;
use App\Events\UserApproved;
use App\Events\UserVerified;
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

    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'approved',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function ingredients()
    {
        return $this->hasMany(Ingredient::class);
    }
    
    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    public function likedRecipes()
    {
        return $this->belongsToMany(Recipe::class, 'likes');
    }

    public function setPasswordAttribute($input): void
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function getFullName(): string
    {
        return $this->name;
    }
    
    public function getAvatar($size = 36): string
    {
        return 'https://www.gravatar.com/avatar/' . md5($this->email) . '?s=' . $size;
    }

    public function get2faEnabled(): bool
    {
        return !(is_null($this->two_factor_secret));
    }

    public function getRecoveryCodes(): array
    {
        return json_decode(decrypt($this->two_factor_recovery_codes));
    }

    public static function getTableName(): string
    {
        return (new self())->getTable();
    }

    public static function boot()
    {
        parent::boot();

        static::updated(function($user) {
            if ($user->isDirty('email_verified_at')) {
                if ($user->getOriginal('email_verified_at') == null && $user->email_verified_at != null)  {
                    event(new UserVerified($user));
                }
            }
            if ($user->isDirty('approved')) {
                if ($user->getOriginal('approved') == 0 && $user->approved == 1)  {
                    event(new UserApproved($user));
                }
            }
        });
    }
}
