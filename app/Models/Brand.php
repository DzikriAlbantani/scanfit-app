<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Brand extends Model
{
    protected $fillable = [
        'owner_id',
        'brand_name',
        'description',
        'verified',
        'status',
        'logo_url',
        'proposal_file',
        'subscription_plan',
        'is_premium',
        'subscription_expires_at',
    ];

    protected $casts = [
        'verified' => 'boolean',
        'is_premium' => 'boolean',
        'subscription_expires_at' => 'datetime',
    ];

    public function getNameAttribute(): string
    {
        return $this->brand_name;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function fashionItems(): HasMany
    {
        return $this->hasMany(FashionItem::class);
    }

    public function banners(): HasMany
    {
        return $this->hasMany(BrandBanner::class);
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

    public function isPro(): bool
    {
        if (!$this->subscription_plan) {
            return false;
        }

        if (!$this->subscription_expires_at) {
            return $this->subscription_plan === 'pro';
        }

        return $this->subscription_plan === 'pro' && $this->subscription_expires_at->isFuture();
    }

    public function hasActiveSubscription(): bool
    {
        return $this->subscription_plan !== 'basic'
            && $this->subscription_expires_at
            && $this->subscription_expires_at->isFuture();
    }
}
