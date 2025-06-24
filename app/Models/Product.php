<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $casts = [
        'discount_end_at' => 'datetime',
    ];


    protected $fillable = [
        'name',
        'code',
        'description',
        'price',
        'inventory',
        'image',
        'status',
        'featured',
        'category_id',
        'discount_percent',
        'discount_end_at',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function getFinalPriceAttribute()
    {
        if ($this->discount_percent > 0 && (!$this->discount_end_at || now()->lt($this->discount_end_at))) {
            return round($this->price * (1 - $this->discount_percent / 100));
        }

        return $this->price;
    }
}
