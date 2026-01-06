<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BrandBanner extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'title',
        'description',
        'banner_image_url',
        'link_url',
        'cta_text',
        'status',
        'started_at',
        'ended_at',
        'clicks',
        'impressions',
        'budget',
        'rejection_reason',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function placements(): HasMany
    {
        return $this->hasMany(BannerPlacement::class, 'banner_id');
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function isActive(): bool
    {
        return $this->status === 'active' && 
               (!$this->started_at || $this->started_at <= now()) &&
               (!$this->ended_at || $this->ended_at >= now());
    }

    public function recordClick(): void
    {
        $this->increment('clicks');
    }

    public function recordImpression(): void
    {
        $this->increment('impressions');
    }

    public function getCtRAttribute(): float
    {
        if ($this->impressions === 0) return 0;
        return ($this->clicks / $this->impressions) * 100;
    }
}
