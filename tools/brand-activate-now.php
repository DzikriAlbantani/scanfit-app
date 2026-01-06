<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Payment;
use App\Models\Brand;

$payment = Payment::where('metadata->brand_subscription', true)->where('status', 'paid')->latest()->first();

if (!$payment) {
    echo "No paid brand payments found\n";
    exit(0);
}

$cycle = $payment->metadata['cycle'] ?? 'monthly';
$renewalDate = $cycle === 'yearly' ? now()->addYear() : now()->addMonth();

$brandId = $payment->metadata['brand_id'] ?? null;
$brand = $brandId ? Brand::find($brandId) : null;

if (!$brand) {
    echo "Brand not found for payment ID {$payment->id}\n";
    exit(1);
}

$brand->subscription_plan = $payment->plan;
$brand->is_premium = $payment->plan !== 'basic';
$brand->subscription_expires_at = $renewalDate;
$brand->save();

echo "Activated brand {$brand->id} ({$brand->brand_name}) to plan {$payment->plan} until {$renewalDate}\n";
