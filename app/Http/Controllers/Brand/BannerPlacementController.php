<?php

namespace App\Http\Controllers\Brand;

use App\Http\Controllers\Controller;
use App\Models\BannerPlacement;
use App\Models\BrandBanner;
use App\Models\Payment;
use App\Services\Payments\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BannerPlacementController extends Controller
{
    public function create(BrandBanner $banner)
    {
        $brand = Auth::user()->brand;
        abort_unless($banner->brand_id === $brand->id, 403);

        $dailyFee = (int) config('pricing.banner_daily_fee');

        return view('brand.banners.placement_checkout', [
            'banner' => $banner,
            'dailyFee' => $dailyFee,
        ]);
    }

    public function store(Request $request, BrandBanner $banner)
    {
        $brand = Auth::user()->brand;
        abort_unless($banner->brand_id === $brand->id, 403);

        $data = $request->validate([
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'days' => ['required', 'integer', 'min:1', 'max:365'],
        ]);

        $dailyFee = (int) config('pricing.banner_daily_fee');
        $start = \Carbon\Carbon::parse($data['start_date'])->startOfDay();
        $end = (clone $start)->addDays($data['days'] - 1)->endOfDay();
        $total = $dailyFee * (int)$data['days'];

        $orderId = 'BNR-' . Str::upper(Str::random(12));

        $payment = Payment::create([
            'user_id' => $request->user()->id,
            'order_id' => $orderId,
            'plan' => 'banner-placement',
            'amount' => $total,
            'status' => 'pending',
            'metadata' => [
                'type' => 'banner_placement',
                'banner_id' => $banner->id,
                'brand_id' => $brand->id,
                'days' => (int)$data['days'],
                'daily_fee' => $dailyFee,
            ],
        ]);

        $placement = BannerPlacement::create([
            'banner_id' => $banner->id,
            'brand_id' => $brand->id,
            'start_date' => $start->toDateString(),
            'end_date' => $end->toDateString(),
            'days' => (int)$data['days'],
            'daily_fee' => $dailyFee,
            'total_amount' => $total,
            'status' => 'pending',
            'payment_id' => $payment->id,
            'metadata' => [ 'order_id' => $orderId ],
        ]);

        $service = new MidtransService();
        $payload = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $total,
            ],
            'item_details' => [
                [
                    'id' => 'banner-' . $banner->id,
                    'price' => $dailyFee,
                    'quantity' => (int)$data['days'],
                    'name' => 'Penayangan Banner ' . $banner->title,
                ],
            ],
            'customer_details' => [
                'first_name' => $request->user()->name,
                'email' => $request->user()->email,
            ],
            'callbacks' => [
                'finish' => route('brand.bannerPlacements.finish', [$banner->id, $placement->id]),
            ],
        ];

        $result = $service->createSnapTransaction($payload);

        $payment->update([
            'snap_token' => $result['token'] ?? null,
            'snap_redirect_url' => $result['redirect_url'] ?? null,
            'metadata' => array_merge($payment->metadata ?? [], [
                'banner_placement_id' => $placement->id,
            ], $result),
        ]);

        return view('brand.banners.placement_checkout', [
            'banner' => $banner,
            'dailyFee' => $dailyFee,
            'placement' => $placement,
            'snapToken' => $result['token'] ?? null,
            'clientKey' => $service->clientKey(),
        ]);
    }

    public function finish(Request $request, BrandBanner $banner, BannerPlacement $placement)
    {
        // Show a simple status page; actual activation handled via webhook
        return redirect()->route('brand.banners.show', $banner)
            ->with('success', 'Transaksi diproses. Status penayangan akan diperbarui setelah pembayaran tersettlement.');
    }
}
