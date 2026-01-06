<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Brand;
use App\Models\User;

$name = $argv[1] ?? 'Erigo';
$brand = Brand::where('brand_name', 'like', $name . '%')->first();
if (!$brand) {
    echo "Brand not found\n";
    exit(1);
}

echo "Brand:\n";
print_r($brand->only(['id','brand_name','status','subscription_plan','is_premium','subscription_expires_at','owner_id']));

$user = User::find($brand->owner_id);
if ($user) {
    echo "\nOwner:\n";
    print_r($user->only(['id','name','email','role','subscription_plan','is_premium','subscription_expires_at']));
}
