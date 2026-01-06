<?php
/**
 * Test Payment Success - Manual webhook trigger for development
 * Access: /test-payment-success.php
 */

// Get environment
$env = getenv('APP_ENV') ?: 'local';
$isDev = in_array($env, ['local', 'development']);

if (!$isDev) {
    http_response_code(403);
    die('This endpoint is only available in development mode.');
}

require __DIR__ . '/../bootstrap/app.php';

use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\Log;

// Check if there are any pending payments
$pendingPayments = Payment::where('status', 'pending')
    ->orderByDesc('created_at')
    ->limit(10)
    ->get();

if ($pendingPayments->isEmpty()) {
    echo "❌ No pending payments found.\n";
    echo "Please make a payment first, then this script will help you simulate the webhook.\n";
    exit(1);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Payment Success - Development Only</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .container { background: white; border-radius: 12px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); max-width: 800px; width: 100%; padding: 40px; }
        h1 { color: #333; margin-bottom: 10px; font-size: 28px; }
        .subtitle { color: #666; margin-bottom: 30px; font-size: 14px; }
        .warning { background: #fff3cd; border: 1px solid #ffc107; border-radius: 8px; padding: 15px; margin-bottom: 30px; color: #856404; }
        .payment-card { background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px; margin-bottom: 10px; cursor: pointer; transition: all 0.3s; }
        .payment-card:hover { background: #e9ecef; border-color: #667eea; }
        .payment-card.active { background: #e7f0ff; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        .payment-info { display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; }
        .payment-label { font-weight: 600; color: #333; }
        .payment-value { color: #666; font-size: 14px; }
        .payment-status { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .status-pending { background: #fff3cd; color: #856404; }
        .amount-badge { color: #667eea; font-weight: 700; }
        .button-group { display: flex; gap: 10px; margin-top: 30px; }
        button { padding: 12px 24px; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.3s; }
        .btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; flex: 1; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3); }
        .btn-secondary { background: #e9ecef; color: #333; flex: 1; }
        .btn-secondary:hover { background: #dee2e6; }
        .result { margin-top: 30px; padding: 20px; border-radius: 8px; display: none; }
        .result.success { background: #d4edda; border: 1px solid #c3e6cb; color: #155724; }
        .result.error { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; }
        .result h3 { margin-bottom: 10px; font-size: 18px; }
        .result pre { background: white; padding: 10px; border-radius: 4px; overflow-x: auto; font-size: 12px; margin-top: 10px; }
        .selected-info { margin-top: 20px; padding: 15px; background: #e7f0ff; border-radius: 8px; border-left: 4px solid #667eea; display: none; }
        .selected-info.show { display: block; }
    </style>
</head>
<body>
    <div class="container">
        <h1>⚙️ Test Payment Success</h1>
        <p class="subtitle">Development Only - Simulate Payment Webhook</p>

        <div class="warning">
            <strong>⚠️ Warning:</strong> This is a development tool. It will directly update your database with a successful payment status and activate the subscription.
        </div>

        <h2 style="color: #333; font-size: 18px; margin-bottom: 15px;">Recent Pending Payments</h2>
        
        <form id="paymentForm" method="POST" action="">
            <?php foreach ($pendingPayments as $payment): ?>
                <?php
                    $user = $payment->user;
                    $plan = strtoupper($payment->plan);
                    $amount = number_format($payment->amount, 0, ',', '.');
                    $createdAt = $payment->created_at->format('d M Y, H:i');
                    $orderId = $payment->order_id;
                ?>
                <label class="payment-card" data-payment-id="<?= $payment->id ?>">
                    <input type="radio" name="payment_id" value="<?= $payment->id ?>" style="margin-right: 10px;">
                    <div class="payment-info">
                        <div style="flex: 1;">
                            <div class="payment-label"><?= $plan ?> - <?= $user->name ?> (<?= $user->email ?>)</div>
                            <div class="payment-value">Order: <?= $orderId ?> • <?= $createdAt ?></div>
                        </div>
                        <div class="amount-badge" style="text-align: right;">Rp <?= $amount ?></div>
                        <span class="payment-status status-pending" style="margin-left: 10px;">Pending</span>
                    </div>
                </label>
            <?php endforeach; ?>

            <div class="selected-info" id="selectedInfo">
                <div id="selectedDetails"></div>
            </div>

            <div class="button-group">
                <button type="submit" class="btn-primary">✅ Trigger Webhook & Activate</button>
                <button type="button" class="btn-secondary" onclick="location.reload()">Refresh</button>
            </div>
        </form>

        <div id="result" class="result"></div>
    </div>

    <script>
        const form = document.getElementById('paymentForm');
        const paymentCards = document.querySelectorAll('.payment-card');
        const selectedInfo = document.getElementById('selectedInfo');
        const selectedDetails = document.getElementById('selectedDetails');
        const resultDiv = document.getElementById('result');

        // Payment card selection
        paymentCards.forEach(card => {
            card.addEventListener('click', function() {
                paymentCards.forEach(c => c.classList.remove('active'));
                this.classList.add('active');
                this.querySelector('input[type="radio"]').checked = true;
                
                const paymentId = this.dataset.paymentId;
                const paymentText = this.querySelector('.payment-label').textContent;
                const amount = this.querySelector('.amount-badge').textContent;
                
                selectedDetails.innerHTML = `<strong>Selected:</strong> ${paymentText}<br/><strong>Amount:</strong> ${amount}`;
                selectedInfo.classList.add('show');
            });
        });

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const paymentId = document.querySelector('input[name="payment_id"]:checked')?.value;
            if (!paymentId) {
                showResult('error', 'Please select a payment first');
                return;
            }

            try {
                // Make request to trigger webhook
                const response = await fetch(`/test-trigger-webhook?payment_id=${paymentId}`, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });

                const data = await response.json();

                if (response.ok) {
                    showResult('success', 'Webhook triggered successfully!', data);
                    setTimeout(() => {
                        window.location.href = '/payment/success/' + paymentId;
                    }, 2000);
                } else {
                    showResult('error', 'Failed to trigger webhook', data);
                }
            } catch (error) {
                showResult('error', 'Error: ' + error.message);
            }
        });

        function showResult(type, message, data = null) {
            resultDiv.className = `result ${type}`;
            let html = `<h3>${type === 'success' ? '✅' : '❌'} ${message}</h3>`;
            if (data) {
                html += `<pre>${JSON.stringify(data, null, 2)}</pre>`;
            }
            resultDiv.innerHTML = html;
            resultDiv.style.display = 'block';
            window.scrollTo(0, resultDiv.offsetTop - 100);
        }

        // Auto-select first payment
        const firstRadio = document.querySelector('input[type="radio"]');
        if (firstRadio) {
            firstRadio.checked = true;
            const firstCard = document.querySelector('.payment-card');
            firstCard.classList.add('active');
            firstCard.click();
        }
    </script>
</body>
</html>
