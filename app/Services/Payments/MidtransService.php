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

    public function createSnapTransaction(array $payload): array
    {
        // Disable SSL verification for sandbox (safe for testing)
        // For production, ensure proper CA certificate is installed
        $options = !config('midtrans.is_production') 
            ? ['verify' => false]
            : [];

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
