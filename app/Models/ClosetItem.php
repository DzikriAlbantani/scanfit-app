<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClosetItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'fashion_item_id',
        'outfit_album_id',
        'image_url',
        'name',
        'description',
        'category',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function fashionItem(): BelongsTo
    {
        return $this->belongsTo(FashionItem::class);
    }

    public function outfitAlbum(): BelongsTo
    {
        return $this->belongsTo(OutfitAlbum::class, 'outfit_album_id');
    }
}
