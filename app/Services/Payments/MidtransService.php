<?php

namespace App\Services\Payments;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MidtransService
{
    protected string $serverKey;
    protected string $clientKey;
    protected string $snapUrl;

    public function __construct()
    {
        $this->serverKey = config('midtrans.server_key');
        $this->clientKey = config('midtrans.client_key');
        $this->snapUrl = config('midtrans.snap_base_url');
    }

    public function clientKey(): string
    {
        return $this->clientKey;
    }

    public function fetchStatus(string $orderId): array
    {
        $baseUrl = config('midtrans.is_production')
            ? 'https://api.midtrans.com/v2/'
            : 'https://api.sandbox.midtrans.com/v2/';

        $url = $baseUrl . $orderId . '/status';

        $options = !config('midtrans.is_production') 
            ? ['verify' => false]
            : [];

        $response = Http::withBasicAuth($this->serverKey, '')
            ->withOptions($options)
            ->get($url);

        if (!$response->successful()) {
            Log::error('Midtrans status error', [
                'order_id' => $orderId,
                'status' => $response->status(),
                'body' => $response->json(),
            ]);
            throw new \RuntimeException('Gagal mengambil status Midtrans');
        }

        return $response->json();
    }

    public function createSnapTransaction(array $payload): array
    {
        // Add notification URL for webhook callback (correct format for Midtrans)
        $webhookUrl = config('app.url') . '/payments/midtrans/notify';
        
        // Set up callbacks for user redirection after payment
        if (!isset($payload['callbacks'])) {
            $payload['callbacks'] = [];
        }
        $payload['callbacks']['finish'] = config('app.url') . '/payment/finish';
        $payload['callbacks']['unfinish'] = config('app.url') . '/payment/finish';
        $payload['callbacks']['error'] = config('app.url') . '/payment/finish';
        
        // CRITICAL: Set notification URL at root level for Midtrans webhook
        // This is where Midtrans will send payment status updates
        $payload['notification_url'] = $webhookUrl;

        // Disable SSL verification for sandbox (safe for testing)
        // For production, ensure proper CA certificate is installed
        $options = !config('midtrans.is_production') 
            ? ['verify' => false]
            : [];

        Log::info('Creating Snap transaction with webhook', [
            'notification_url' => $webhookUrl,
            'callbacks' => $payload['callbacks'] ?? null,
            'order_id' => $payload['transaction_details']['order_id'] ?? null,
        ]);

        $response = Http::withBasicAuth($this->serverKey, '')
            ->withOptions($options)
            ->asJson()
            ->post($this->snapUrl, $payload);

        if (!$response->successful()) {
            Log::error('Midtrans Snap error', [
                'status' => $response->status(),
                'body' => $response->json(),
            ]);
            throw new \RuntimeException('Gagal membuat transaksi Midtrans');
        }

        return $response->json();
    }
}
