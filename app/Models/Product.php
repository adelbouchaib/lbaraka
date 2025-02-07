<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


class Product extends Model
{
    protected $fillable = [
        'category_id',
        'seller_id',
        'name',
        'slug',
        'images',
        'description',
        'price',
        'quantity',
        'is_active',
        'in_stock',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function conversations()
    {
        return $this->belongsToMany(FilachatConversation::class, 'conversation_product');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->slug = static::generateUniqueSlug($product->name);
        });

        static::creating(function ($product) {
            if (!isset($product->seller_id)) {
                $product->seller_id = Auth::id(); // Set default seller ID
            }
        });
    }

    public static function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $count = static::where('slug', 'LIKE', "$slug%")->count();

        return $count ? "{$slug}-" . ($count + 1) : $slug;
    }

}
