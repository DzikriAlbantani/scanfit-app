<?php

use Illuminate\Support\Facades\Route;

Route::get('/test-subscription', function () {
    $user = auth()->user();
    
    if (!$user) {
        return 'Please login first';
    }
    
    $user->refresh();
    auth()->setUser($user);
    
    return [
        'user_id' => $user->id,
        'name' => $user->name,
        'subscription_plan' => $user->subscription_plan,
        'is_premium' => $user->is_premium,
        'subscription_expires_at' => $user->subscription_expires_at,
        'isPremium()' => $user->isPremium(),
        'hasActiveSubscription()' => $user->hasActiveSubscription(),
    ];
})->middleware('auth');
