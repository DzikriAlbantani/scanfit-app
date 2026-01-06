<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profile_photo_path',
        'is_premium',
        'subscription_plan',
        'subscription_expires_at',
        'scan_count_monthly',
        'last_scan_reset',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_premium' => 'boolean',
            'subscription_expires_at' => 'datetime',
            'last_scan_reset' => 'date',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isBrand(): bool
    {
        return $this->role === 'brand_owner';
    }

    public function brand(): HasOne
    {
        return $this->hasOne(Brand::class, 'owner_id');
    }

    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    }

    public function scans(): HasMany
    {
        return $this->hasMany(Scan::class);
    }

    public function isPremium(): bool
    {
        return (bool)($this->is_premium ?? false) && $this->hasActiveSubscription();
    }

    public function hasActiveSubscription(): bool
    {
        if (!$this->subscription_expires_at) {
            return false;
        }
        return $this->subscription_expires_at > now();
    }

    public function getSubscriptionBenefits(): array
    {
        $plan = strtolower($this->subscription_plan ?? 'basic');
        return config("pricing.plans.{$plan}.features", []);
    }

    public function getSubscriptionInfo(): array
    {
        $plan = strtolower($this->subscription_plan ?? 'basic');
        $config = config("pricing.plans.{$plan}", []);
        return [
            'plan' => $plan,
            'name' => $config['name'] ?? ucfirst($plan),
            'is_active' => $this->hasActiveSubscription(),
            'expires_at' => $this->subscription_expires_at,
            'features' => $config['features'] ?? [],
        ];
    }

    public function remainingFreeScans(): int
    {
        $limit = (int)config('scan.free_limit', 10);
        $used = $this->scans()->count();
        return max(0, $limit - $used);
    }

    /**
     * Check if user has quota for a feature: 'scan' or 'closet'.
     */
    public function hasQuotaFor(string $feature): bool
    {
        if ($this->isPremium()) {
            return true;
        }

        $plan = strtolower($this->subscription_plan ?? 'basic');

        // Pro is unlimited for all features
        if ($plan === 'pro') {
            return true;
        }

        if ($feature === 'scan') {
            $this->ensureMonthlyScanReset();

            $limits = [
                'basic' => 10,
                'plus' => 50,
            ];
            $limit = $limits[$plan] ?? 10;

            return ($this->scan_count_monthly ?? 0) < $limit;
        }

        if ($feature === 'closet') {
            $limits = [
                'basic' => 15,
                'plus' => 100,
            ];
            $limit = $limits[$plan] ?? 15;
            // Count current closet items
            $count = $this->closetItems()->count();
            return $count < $limit;
        }

        // Unknown feature: deny by default
        return false;
    }

    /**
     * Reset monthly scan count at the start of a new month.
     */
    public function ensureMonthlyScanReset(): void
    {
        $today = now();
        $startOfMonth = $today->copy()->startOfMonth()->toDateString();
        if (empty($this->last_scan_reset) || $this->last_scan_reset < $startOfMonth) {
            $this->scan_count_monthly = 0;
            $this->last_scan_reset = $startOfMonth;
            // Avoid triggering events; keep minimal
            $this->saveQuietly();
        }
    }

    /**
     * Increment monthly scan usage and persist.
     */
    public function incrementMonthlyScanUsage(): void
    {
        $this->ensureMonthlyScanReset();
        $this->scan_count_monthly = ($this->scan_count_monthly ?? 0) + 1;
        $this->saveQuietly();
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function brands(): HasMany
    {
        return $this->hasMany(Brand::class, 'owner_id');
    }

    public function closetItems(): HasMany
    {
        return $this->hasMany(ClosetItem::class);
    }

    public function albums(): HasMany
    {
        return $this->hasMany(OutfitAlbum::class);
    }

    public function getProfilePhotoUrlAttribute()
    {
        return $this->profile_photo_path ? \Illuminate\Support\Facades\Storage::url($this->profile_photo_path) : null;
    }
}
