<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'brand_id',
        'name',
        'description',
        'price',
        'stock',
        'image_url',
        'is_affiliate',
        'affiliate_link',
        'style',
        'fit_type',
        'dominant_color',
        'category',
        'gender_target',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_affiliate' => 'boolean',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
}
