<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FashionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'name',
        'category',
        'price',
        'original_price',
        'rating',
        'review_count',
        'store_name',
        'image_url',
        'link_shopee',
        'link_tokopedia',
        'link_tiktok',
        'link_lazada',
        'sizes',
        'colors',
        'description',
        'clicks_count',
        'style',
        'fit_type',
        'dominant_color',
        'gender_target',
        'stock',
        'status',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function closetItems()
    {
        return $this->hasMany(\App\Models\ClosetItem::class, 'fashion_item_id');
    }

    protected $casts = [
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'rating' => 'decimal:1',
        'sizes' => 'array',
        'colors' => 'array',
    ];
}
