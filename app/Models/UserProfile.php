<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id',
        'gender',
        'style_preference',
        'skin_tone',
        'body_size',
        'favorite_color',
        'main_need',
    ];

    protected $casts = [
        //
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
