<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClickEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'fashion_item_id',
        'user_id',
        'source',
        'ip',
        'user_agent',
    ];

    public function fashionItem(): BelongsTo
    {
        return $this->belongsTo(FashionItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
