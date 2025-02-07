<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Auth;


class Request extends Model
{
    protected $fillable = [
        'buyer_id',
        'category_id',
        'name',
        'images',
        'description',
        'quantity',
        'chat_nb',
        'status'
    ];

    protected $casts = [
        'images' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function conversations()
    {
        return $this->belongsToMany(FilachatConversation::class, 'conversation_request');
    }
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($request) {
            if (!isset($request->buyer_id)) {
                $request->buyer_id = Auth::id(); // Set default seller ID
            }
        });
    }

}
