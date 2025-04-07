<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = ['name', 'slug', 'logo', 'location', 'seller_id', 'featured_products', 'description'];

    protected $casts = [
        'featured_products' => 'array', // Ensure this is cast as an array when retrieved
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

}
