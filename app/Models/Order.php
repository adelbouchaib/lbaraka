<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'buyer_id',
        'seller_id',
        'orderable_id',
        'orderable_type',
        'status',
    ];

    public function orderable()
    {
        return $this->morphTo();
    }
}
