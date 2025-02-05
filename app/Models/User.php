<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use JaOcero\FilaChat\Traits\HasFilaChat;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasFilaChat;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
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
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'seller_id');
    }

    /**
     * Check if the user is an seller.
     *
     * @return bool
     */
    public function isSeller(): bool
    {
        return $this->role === 'seller'; // Assuming you have a 'role' column in your users table
    }

    public function isBuyer(): bool
    {
        return $this->role === 'buyer'; // Assuming you have a 'role' column in your users table
    }

    
    public function canAccessPanel(Panel $panel): bool
    {
    return match ($panel->getId()) {
        'admin' => $this->isSeller(), // or whatever checks you have
        'buyer' => $this->isBuyer(), // or whatever checks you have
        default => false,
    };
    }



    
}
