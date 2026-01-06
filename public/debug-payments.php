<!DOCTYPE html>
<html>
<head>
    <title>Payment & Subscription Debug</title>
    <style>
        body { font-family: Arial; margin: 20px; background: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #333; color: white; }
        tr:hover { background: #f9f9f9; }
        .status-paid { color: green; font-weight: bold; }
        .status-pending { color: orange; font-weight: bold; }
        .status-failed { color: red; font-weight: bold; }
        h2 { margin-top: 30px; color: #333; }
        .info-box { background: #e3f2fd; padding: 15px; border-radius: 4px; margin: 15px 0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Payment & Subscription Debug</h1>
        
        <?php
            // Check if CLI request or web request
            if (php_sapi_name() === 'cli') {
                echo "This file should be accessed via browser.\n";
                exit;
            }

            require 'vendor/autoload.php';
            $app = require_once 'bootstrap/app.php';
            
            use App\Models\User;
            use App\Models\Payment;
            use Illuminate\Database\Capsule\Manager as DB;

            // Initialize Laravel app
            $kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
            
            // Get last 10 payments
            $payments = Payment::latest()->take(10)->get();
            
            // Get users with premium subscriptions
            $premiumUsers = User::where('is_premium', true)
                ->orWhere('subscription_expires_at', '>', now())
                ->latest()
                ->take(10)
                ->get();
        ?>

        <div class="info-box">
            <strong>ℹ️ Info:</strong> This page shows recent payment and subscription records from the database. 
            Check if your payment record exists and if subscription fields are populated.
        </div>

        <h2>Recent Payments (Last 10)</h2>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User Email</th>
                    <th>Plan</th>
                    <th>Amount (IDR)</th>
                    <th>Status</th>
                    <th>Payment Type</th>
                    <th>Transaction ID</th>
                    <th>Paid At</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($payments as $payment): ?>
                <tr>
                    <td><code><?php echo $payment->order_id; ?></code></td>
                    <td><?php echo $payment->user->email; ?></td>
                    <td><strong><?php echo ucfirst($payment->plan); ?></strong></td>
                    <td><?php echo number_format($payment->amount, 0, ',', '.'); ?></td>
                    <td class="status-<?php echo $payment->status; ?>"><?php echo strtoupper($payment->status); ?></td>
                    <td><?php echo $payment->payment_type ?? '-'; ?></td>
                    <td><code><?php echo substr($payment->midtrans_transaction_id ?? '-', 0, 20) . (strlen($payment->midtrans_transaction_id ?? '') > 20 ? '...' : ''); ?></code></td>
                    <td><?php echo $payment->paid_at?->format('Y-m-d H:i') ?? '-'; ?></td>
                    <td><?php echo $payment->created_at->format('Y-m-d H:i'); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Users with Premium/Active Subscriptions</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Plan</th>
                    <th>Is Premium</th>
                    <th>Expires At</th>
                    <th>Days Left</th>
                    <th>Scan Count</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($premiumUsers as $user): ?>
                <tr>
                    <td><?php echo $user->name; ?></td>
                    <td><?php echo $user->email; ?></td>
                    <td><strong><?php echo ucfirst($user->subscription_plan); ?></strong></td>
                    <td><?php echo $user->is_premium ? '✓ Yes' : '✗ No'; ?></td>
                    <td>
                        <?php 
                            if ($user->subscription_expires_at) {
                                echo $user->subscription_expires_at->format('Y-m-d H:i');
                            } else {
                                echo '-';
                            }
                        ?>
                    </td>
                    <td>
                        <?php 
                            if ($user->subscription_expires_at) {
                                $daysLeft = now()->diffInDays($user->subscription_expires_at);
                                $isActive = $daysLeft > 0;
                                echo '<span style="color: ' . ($isActive ? 'green' : 'red') . '">' . $daysLeft . ' days</span>';
                            } else {
                                echo '-';
                            }
                        ?>
                    </td>
                    <td><?php echo $user->scan_count_monthly ?? 0; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Debug Instructions</h2>
        <div class="info-box">
            <h3>If your payment doesn't appear:</h3>
            <ol>
                <li>Check if your payment record was created: look for your Order ID in the "Recent Payments" table above</li>
                <li>If the payment exists but status is "pending", the webhook hasn't been received yet</li>
                <li>Wait a few minutes for Midtrans webhook to arrive, then refresh this page</li>
                <li>Check logs: <code>tail storage/logs/laravel.log | grep -i webhook</code></li>
            </ol>
            
            <h3>If the subscription doesn't activate:</h3>
            <ol>
                <li>Make sure the payment status is "paid" (not "pending" or "failed")</li>
                <li>Check if webhook handler logged the activation: <code>grep "Subscription activated" storage/logs/laravel.log</code></li>
                <li>Manually refresh user's subscription using Tinker:
                    <pre>php artisan tinker
User::find(YOUR_USER_ID)->update([
    'subscription_plan' => 'plus',
    'is_premium' => true,
    'subscription_expires_at' => now()->addMonth()
])
                    </pre>
                </li>
            </ol>
        </div>

        <h2>Webhook Configuration</h2>
        <div class="info-box">
            <p><strong>Webhook URL:</strong> <code><?php echo config('app.url'); ?>/payments/midtrans/notify</code></p>
            <p><strong>Status:</strong> 
                <?php 
                    if (strpos(config('app.url'), 'localhost') !== false || strpos(config('app.url'), '127.0.0.1') !== false) {
                        echo '⚠️ <strong>Local development</strong> - Webhook will NOT work locally. Use <a href="https://ngrok.com" target="_blank">ngrok</a> or <a href="https://localtunnel.github.io/www/" target="_blank">Localtunnel</a> to expose local server.';
                    } else {
                        echo '✓ Production URL - Webhook should work';
                    }
                ?>
            </p>
            <p><strong>To configure in Midtrans Dashboard:</strong></p>
            <ol>
                <li>Login to Midtrans Dashboard</li>
                <li>Go to Settings → HTTP Notifications</li>
                <li>Set <strong>Notification URL</strong> to: <code><?php echo config('app.url'); ?>/payments/midtrans/notify</code></li>
                <li>Enable: Payment Success, Payment Failed, Payment Denied</li>
            </ol>
        </div>
    </div>
</body>
</html>
