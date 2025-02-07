<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FilachatConversation extends Model
{
    protected $fillable = ['senderable_id', 'senderable_type', 'receiverable_id', 'receiverable_type'];
    public function products()
    {
        return $this->belongsToMany(Product::class, 'conversation_product');
    }
    public function requests()
    {
        return $this->belongsToMany(Request::class, 'conversation_request');
    }
}
