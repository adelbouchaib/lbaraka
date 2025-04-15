<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use JaOcero\FilaChat\Traits\HasFilaChat;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Http;

use Filament\Facades\Filament;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;


class User extends Authenticatable implements FilamentUser, MustVerifyEmail
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
        'phone',
        'password',
        'google_id', 
        'email_verified_at',
        'role',
        'products_limit',
        'type',
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

    public function buyerOrders()
    {
        return $this->hasMany(Order::class, 'buyer_id');
    }

    public function sellerOrders()
    {
        return $this->hasMany(Order::class, 'seller_id');
    }

    public function buyerInquiries()
    {
        return $this->hasMany(Order::class, 'buyer_id');
    }

    public function sellerInquiries()
    {
        return $this->hasMany(Order::class, 'seller_id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function buyerReports()
    {
        return $this->hasMany(Report::class, 'buyer_id');
    }

    public function sellerReports()
    {
        return $this->hasMany(Report::class, 'seller_id');
    }

    public function store()
    {
        return $this->hasOne(Store::class, 'seller_id');
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

    public function isSadmin(): bool
    {
        return $this->role === 'sadmin'; // Assuming you have a 'role' column in your users table
    }

    
    public function canAccessPanel(Panel $panel): bool
    {
    return match ($panel->getId()) {
        'seller' => $this->isSeller(), // or whatever checks you have
        'buyer' => $this->isBuyer(), // or whatever checks you have
        'sadmin' => $this->isSadmin(), // or whatever checks you have
        default => false,
    };
    }

    public function canPostProduct(): bool
    {
        return $this->role === 'seller' && $this->products()->count() < $this->products_limit;
    }

    


    protected static function booted()
{
    static::created(function ($user) {
        
         
        $apiKey = env('BREVO_API_KEY');

        // $user = auth()->user();

        $verificationUrl = URL::temporarySignedRoute(
            'filament.buyer.auth.email-verification.verify', // your route name
            Carbon::now()->addMinutes(config('auth.verification.expire', 60)), // expiration
            [
                'id' => $user->getKey(),
                'hash' => sha1($user->getEmailForVerification()),
            ]
        );

        $response = Http::withHeaders([
            'api-key' => $apiKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.brevo.com/v3/smtp/email',[
        'sender' =>    
        [
            'name' => 'Supplaio',
            'email' => 'no-reply@supplaio.com'
        ],
        'to' => [
        [ 'email' => $user->email ]
        ],
        'subject' => 'Verify your email address',
        'htmlContent' => "
            <html>
                <body>
                        <h2 style=\"color: #2c3e50;\">Hello {$user->name},</h2>
                        <p style=\"font-size: 16px;\">Thank you for registering with us!</p>
                        <p style=\"font-size: 16px;\">To complete your registration, please verify your email by clicking the button below:</p>
                        
                        <p style=\"text-align: center; margin: 30px 0;\">
                            <a href=\"{$verificationUrl}\" style=\"display: inline-block; background-color: #1a73e8; color: #fff; text-decoration: none; padding: 12px 24px; border-radius: 5px; font-size: 16px;\">
                                Verify Email
                            </a>
                        </p>
                </body>
            </html>            
        ",
        'trackLinks' => 'none',


    ]);
    

});
}



    
}
