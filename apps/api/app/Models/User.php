<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles;
    protected $guard_name = 'web';

    protected $fillable = [
        'name', 'email', 'password', 'address_id', 'status'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    // create profile with defaults
    protected static function booted()
    {
        static::created(function ($user) {
            if (! $user->profile) {
                $user->profile()->create([]);
            }
        });
    }
}
