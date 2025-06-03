<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $fillable = ['name', 'email', 'password', 'role', 'email_verified_at', 'email_verification_code'];

    protected $hidden = ['password', 'email_verification_code'];

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function watchlists()
    {
        return $this->hasMany(Watchlist::class);
    }
}
