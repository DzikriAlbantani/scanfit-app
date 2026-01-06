<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Brand;
use App\Services\Payments\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    protected array $planPrices = [
        'basic' => 0,
    ];

    public function checkout(Request $request, string $plan)
    {
        $plan = strtolower($plan);
        $config = config('pricing.plans');
        if ($plan !== 'basic' && !isset($config[$plan])) {
            return redirect()->route('pricing.index')->with('error', 'Paket tidak valid.');
        }

        $user = $request->user();
        $cycle = strtolower($request->query('cycle', 'monthly'));
        if ($plan === 'basic') {
            $base = 0;
            $amount = 0;
        } else {
            $base = (int)($config[$plan]['monthly_price'] ?? 0);
            if ($cycle === 'yearly') {
                $discountMonths = (int)($config[$plan]['yearly_discount_months'] ?? 0);
                $monthsToPay = max(0, 12 - $discountMonths);
                $amount = $base * $monthsToPay;
            } else {
                $amount = $base;
            }
        }
        if ($amount <= 0) {
            return redirect()->route('subscription.upgrade', $plan);
        }

        $orderId = 'SF-' . Str::upper(Str::random(10));

        $payment = Payment::create([
            'user_id' => $user->id,
            'order_id' => $orderId,
            'plan' => $plan,
            'amount' => $amount,
            'status' => 'pending',
            'metadata' => [
                'cycle' => $cycle,
                'user_id' => $user->id,
                'plan' => $plan,
                'email' => $user->email,
            ],
        ]);

        $service = new MidtransService();
        $payload = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $amount,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
            'item_details' => [
                [
                    'id' => 'plan-' . $plan . '-' . $cycle,
                    'price' => $amount,
                    'quantity' => 1,
                    'name' => 'ScanFit ' . ucfirst($plan) . ' (' . ucfirst($cycle) . ')',
                ],
            ],
        ];

        Log::info('Creating Snap transaction', [
            'order_id' => $orderId,
            'user_id' => $user->id,
            'plan' => $plan,
            'amount' => $amount,
        ]);

        try {
            $result = $service->createSnapTransaction($payload);
            
            Log::info('Snap transaction created', [
                'order_id' => $orderId,
                'token' => $result['token'] ?? 'NO TOKEN',
                'redirect_url' => $result['redirect_url'] ?? 'NO REDIRECT',
            ]);
        } catch (\Exception $e) {
            Log::error('Snap transaction failed', [
                'order_id' => $orderId,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }

        $payment->update([
            'snap_token' => $result['token'] ?? null,
            'snap_redirect_url' => $result['redirect_url'] ?? null,
            'metadata' => array_merge($payment->metadata ?? [], $result, [
                'cycle' => $cycle,
                'base_price' => $base,
            ]),
        ]);

        return view('payments.checkout', [
            'snapToken' => $result['token'] ?? null,
            'clientKey' => $service->clientKey(),
            'payment' => $payment,
        ]);
    }

    public function success(Request $request, $paymentId)
    {
        $payment = Payment::findOrFail($paymentId);
        
        // Ensure user can only see their own payments
        if ($payment->user_id !== $request->user()->id) {
            abort(403);
        }

        // Refresh user data from database to get latest subscription status
        $user = $request->user();
        $user->refresh();

        // If webhook belum masuk, fallback: cek status ke Midtrans lalu aktifkan
        if ($payment->status !== 'paid' && $payment->order_id) {
            try {
                $service = new MidtransService();
                $status = $service->fetchStatus($payment->order_id);

                $transactionStatus = $status['transaction_status'] ?? null;
                $statusMap = [
                    'capture' => 'paid',
                    'settlement' => 'paid',
                    'pending' => 'pending',
                    'deny' => 'failed',
                    'expire' => 'expired',
                    'cancel' => 'canceled',
                    'failure' => 'failed',
                ];

                $mapped = $statusMap[$transactionStatus] ?? null;
                if ($mapped) {
                    $payment->update([
                        'status' => $mapped,
                        'payment_type' => $status['payment_type'] ?? $payment->payment_type,
                        'midtrans_transaction_id' => $status['transaction_id'] ?? $payment->midtrans_transaction_id,
                        'metadata' => array_merge($payment->metadata ?? [], $status),
                        'paid_at' => $mapped === 'paid' ? now() : $payment->paid_at,
                    ]);
                }

                if ($mapped === 'paid') {
                    $this->activateSubscriptionFromPayment($payment);
                }
            } catch (\Exception $e) {
                Log::error('Failed to fetch Midtrans status on success page', [
                    'payment_id' => $payment->id,
                    'order_id' => $payment->order_id,
                    'error' => $e->getMessage(),
                ]);
            }
        } elseif ($payment->status === 'paid') {
            // Ensure subscription applied when status already paid but brand/user not updated (idempotent)
            $this->activateSubscriptionFromPayment($payment);
        }

        // Brand payments should land back to brand dashboard/analytics
        if (!empty($payment->metadata['brand_subscription'])) {
            return Redirect::route('brand.analytics')->with('success', 'Langganan Pro brand aktif.');
        }

        return view('payments.success', ['payment' => $payment]);
    }

    private function activateSubscriptionFromPayment(Payment $payment): void
    {
        $cycle = $payment->metadata['cycle'] ?? 'monthly';
        $renewalDate = $cycle === 'yearly'
            ? now()->addYear()
            : now()->addMonth();

        if (!empty($payment->metadata['brand_subscription'])) {
            $brandId = $payment->metadata['brand_id'] ?? null;
            $brand = $brandId ? Brand::find($brandId) : null;

            if ($brand) {
                $plan = $payment->plan;

                $brand->subscription_plan = $plan;
                $brand->is_premium = $plan !== 'basic';
                $brand->subscription_expires_at = $renewalDate;
                $brand->save();

                Log::info('Subscription activated for brand', [
                    'brand_id' => $brand->id,
                    'plan' => $plan,
                    'cycle' => $cycle,
                    'expires_at' => $renewalDate->toDateTimeString(),
                    'source' => 'payment_activation',
                ]);
            } else {
                Log::error('Brand not found when activating subscription from payment', [
                    'payment_id' => $payment->id,
                    'brand_id' => $brandId,
                ]);
            }
        } else {
            $user = $payment->user;
            if (!$user) {
                Log::error('User not found when activating subscription from payment', [
                    'payment_id' => $payment->id,
                    'user_id' => $payment->user_id,
                ]);
                return;
            }

            $plan = $payment->plan;

            $user->subscription_plan = $plan;
            $user->is_premium = in_array($plan, ['plus', 'pro']);
            $user->subscription_expires_at = $renewalDate;
            $user->save();

            Log::info('Subscription activated for user', [
                'user_id' => $user->id,
                'plan' => $plan,
                'cycle' => $cycle,
                'expires_at' => $renewalDate->toDateTimeString(),
                'source' => 'payment_activation',
            ]);
        }
    }

    public function webhook(Request $request)
    {
        $payload = $request->all();
        
        Log::info('=== MIDTRANS WEBHOOK RECEIVED ===', [
            'payload_keys' => array_keys($payload),
            'order_id' => $payload['order_id'] ?? null,
            'transaction_status' => $payload['transaction_status'] ?? null,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Validate signature for security (in production)
        if (config('midtrans.is_production')) {
            $serverKey = config('midtrans.server_key');
            $orderId = $payload['order_id'] ?? '';
            $statusCode = $payload['status_code'] ?? '';
            $grossAmount = $payload['gross_amount'] ?? '';
            $signatureKey = $payload['signature_key'] ?? '';
            
            $expectedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);
            
            if ($signatureKey !== $expectedSignature) {
                Log::warning('Webhook: Invalid signature', [
                    'order_id' => $orderId,
                    'expected' => $expectedSignature,
                    'received' => $signatureKey,
                ]);
                return response()->json(['message' => 'Invalid signature'], 403);
            }
        }

        $orderId = $payload['order_id'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;
        $paymentType = $payload['payment_type'] ?? null;
        $transactionId = $payload['transaction_id'] ?? null;

        if (!$orderId) {
            Log::warning('Webhook: No order_id in payload');
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        if (!$transactionStatus) {
            Log::warning('Webhook: No transaction_status in payload', ['order_id' => $orderId]);
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        $payment = Payment::where('order_id', $orderId)->first();
        if (!$payment) {
            Log::warning('Webhook: Payment not found', ['order_id' => $orderId]);
            return response()->json(['message' => 'Order not found'], 404);
        }

        Log::info('Webhook: Payment found', [
            'payment_id' => $payment->id,
            'user_id' => $payment->user_id,
            'current_status' => $payment->status,
            'plan' => $payment->plan,
        ]);

        $statusMap = [
            'capture' => 'paid',
            'settlement' => 'paid',
            'pending' => 'pending',
            'deny' => 'failed',
            'expire' => 'expired',
            'cancel' => 'canceled',
            'failure' => 'failed',
        ];

        $status = $statusMap[$transactionStatus] ?? 'pending';

        Log::info('Webhook: Updating payment status', [
            'transaction_status_raw' => $transactionStatus,
            'mapped_status' => $status,
        ]);

        // Prevent duplicate processing for already processed payments
        if ($payment->status === 'paid' && $status === 'paid') {
            Log::info('Webhook: Payment already processed, skipping', [
                'payment_id' => $payment->id,
            ]);
            return response()->json(['message' => 'ok', 'note' => 'already_processed']);
        }

        $payment->update([
            'status' => $status,
            'payment_type' => $paymentType,
            'midtrans_transaction_id' => $transactionId,
            'metadata' => array_merge($payment->metadata ?? [], $payload),
            'paid_at' => in_array($status, ['paid']) ? now() : $payment->paid_at,
        ]);

        // If this payment is for a banner placement, update its status
        $placementId = $payment->metadata['banner_placement_id'] ?? null;
        if ($placementId) {
            $placement = \App\Models\BannerPlacement::find($placementId);
            if ($placement) {
                if ($status === 'paid') {
                    $placement->status = 'active';
                } elseif (in_array($status, ['expired', 'canceled', 'failed'])) {
                    $placement->status = $status;
                } else {
                    $placement->status = 'pending';
                }
                $placement->save();
                Log::info('Webhook: Banner placement updated', ['placement_id' => $placementId, 'status' => $placement->status]);
            }
        }

        // Activate subscription on successful payment
        if ($status === 'paid') {
            try {
                $this->activateSubscriptionFromPayment($payment);
            } catch (\Exception $e) {
                Log::error('Webhook: Failed to activate subscription', [
                    'payment_id' => $payment->id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
                // Don't fail the webhook response, payment is already marked as paid
            }
        }

        Log::info('=== WEBHOOK PROCESSED SUCCESSFULLY ===', [
            'payment_id' => $payment->id,
            'order_id' => $orderId,
            'status' => $status,
        ]);
        
        return response()->json(['message' => 'ok']);
    }

    public function refreshSubscription(Request $request)
    {
        /**
         * Endpoint ini digunakan untuk refresh subscription data user dari database
         * Dipanggil via AJAX dari success page untuk memastikan user mendapat data terbaru
         */
        $user = $request->user();
        $user->refresh(); // Refresh dari database
        
        // Jika ada pembayaran brand yang sudah paid tetapi brand belum premium, aktifkan sekarang
        $latestBrandPayment = Payment::where('user_id', $user->id)
            ->where('metadata->brand_subscription', true)
            ->where('status', 'paid')
            ->latest()
            ->first();

        if ($latestBrandPayment) {
            $brandId = $latestBrandPayment->metadata['brand_id'] ?? null;
            $brand = $brandId ? Brand::find($brandId) : null;

            if ($brand && (!$brand->is_premium || !$brand->subscription_expires_at || $brand->subscription_expires_at->isPast())) {
                $this->activateSubscriptionFromPayment($latestBrandPayment);
                $brand->refresh();
            }
        }

        // Check latest payment status too
        $latestPayment = Payment::where('user_id', $user->id)
            ->latest()
            ->first();
        
        return response()->json([
            'is_premium' => $user->isPremium(),
            'subscription_plan' => $user->subscription_plan,
            'subscription_expires_at' => $user->subscription_expires_at?->format('Y-m-d H:i:s'),
            'payment_status' => $latestPayment?->status,
            'payment_plan' => $latestPayment?->plan,
            'timestamp' => now()->format('Y-m-d H:i:s'),
        ]);
    }
}
