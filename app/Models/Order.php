<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'buyer_id',
        'seller_id',
        'product_id',
        'quantity',
        'total_price',
        'delivery_receipt',
        'status',
        'approved'
    ];

    protected $casts = [
        'delivery_receipt' => 'array',
    ];

     // Order belongs to a buyer (User)
     public function buyer()
     {
         return $this->belongsTo(User::class, 'buyer_id');
     }
 
     // Order belongs to a seller (User)
     public function seller()
     {
         return $this->belongsTo(User::class, 'seller_id');
     }
 
     // Order belongs to a product
     public function product()
     {
         return $this->belongsTo(Product::class);
     }
   
}
