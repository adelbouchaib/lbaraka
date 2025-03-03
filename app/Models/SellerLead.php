<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerLead extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'business_type',
        'business_wilaya',
        'business_delivery',
        'business_products',
        'products_type',
    ];

    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
    ];


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

}
