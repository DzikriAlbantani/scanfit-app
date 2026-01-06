<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Payment;
use App\Models\Brand;

$payment = Payment::where('metadata->brand_subscription', true)->latest()->first();
if (!$payment) {
    echo "no brand payments\n";
    exit(0);
}

echo "Latest brand payment:\n";
print_r($payment->only(['id','order_id','plan','status','paid_at','metadata']));

$brandId = $payment->metadata['brand_id'] ?? null;
$brand = $brandId ? Brand::find($brandId) : null;
if (!$brand) {
    echo "Brand not found for payment\n";
    exit(1);
}

echo "\nBrand state:\n";
print_r($brand->only(['id','brand_name','owner_id','status','subscription_plan','is_premium','subscription_expires_at']));
