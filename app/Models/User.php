<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relationship With Listings
    public function listings() {
        return $this->hasMany(Listing::class);
    }

        // Method to check if the user is an admin
        public function isAdmin()
        {
            return $this->role === 'admin';
        }
    
        // Method to check if the user is an HR
        public function isHR()
        {
            return $this->role === 'HR';
        }
    
        // Method to check if the user is a normal user
        public function isNormalUser()
        {
            return $this->role === 'normal';
        }

}
