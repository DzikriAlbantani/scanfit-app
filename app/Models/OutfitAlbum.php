<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OutfitAlbum extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'cover_image_url',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ClosetItem::class, 'outfit_album_id');
    }

    public function getItemCountAttribute()
    {
        return $this->items()->count();
    }

    public function getCoverImageAttribute()
    {
        return $this->cover_image_url ?? $this->items()->first()?->image_url;
    }
}
