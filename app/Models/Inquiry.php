<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $fillable = [
        'filachat_conversation_id',
        'buyer_id',
        'seller_id',
        'product_id',
        'message_id',
        'quantity',
        'status'
    ];
    
    public function conversation()
    {
        return $this->belongsTo(FilachatConversation::class, 'filachat_conversation_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function message()
    {
        return $this->belongsTo(FilachatMessage::class);
    }

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
}
