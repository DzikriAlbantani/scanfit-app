<?php

namespace App\Http\Controllers;

use App\Models\FashionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profile = $user->profile;
        $stylePreference = $profile->style_preference ?? null;

        // Recommendations: Personalized based on style_preference
        $recommendationsQuery = FashionItem::with('brand')->whereHas('brand', function ($q) {
            $q->where('status', 'approved');
        });

        if ($stylePreference) {
            $recommendations = $recommendationsQuery->where('style', $stylePreference)->inRandomOrder()->take(4)->get();
            if ($recommendations->count() < 4) {
                // Fallback to random if not enough
                $recommendations = $recommendationsQuery->inRandomOrder()->take(4)->get();
            }
        } else {
            $recommendations = $recommendationsQuery->inRandomOrder()->take(4)->get();
        }

        // Explore Products: 8 random, exclude recommendations if possible
        $excludedIds = $recommendations->pluck('id');
        $exploreProducts = FashionItem::with('brand')
            ->whereHas('brand', function ($q) {
                $q->where('status', 'approved');
            })
            ->whereNotIn('id', $excludedIds)
            ->inRandomOrder()
            ->take(8)
            ->get();

        // Promo Products: Prioritize discounted or high clicks
        $promoProducts = FashionItem::with('brand')
            ->whereHas('brand', function ($q) {
                $q->where('status', 'approved');
            })
            ->where(function ($query) {
                $query->whereColumn('original_price', '>', 'price')
                      ->orWhere('clicks_count', '>', 0);
            })
            ->orderBy('clicks_count', 'desc')
            ->orderByRaw('CASE WHEN original_price > price THEN 1 ELSE 0 END DESC')
            ->take(3)
            ->get();

        // Fallback if not enough
        if ($promoProducts->count() < 3) {
            $additional = FashionItem::with('brand')
                ->whereHas('brand', function ($q) {
                    $q->where('status', 'approved');
                })
                ->whereNotIn('id', $promoProducts->pluck('id'))
                ->inRandomOrder()
                ->take(3 - $promoProducts->count())
                ->get();
            $promoProducts = $promoProducts->merge($additional);
        }

        // Active Banners for Carousel (approved or active status, within schedule window)
        $banners = \App\Models\BrandBanner::whereIn('status', ['active', 'approved'])
            ->where(function ($query) {
                // Check started_at: should be null or already started
                $query->where(function ($q) {
                    $q->whereNull('started_at')
                      ->orWhere('started_at', '<=', now());
                });
            })
            ->where(function ($query) {
                // Check ended_at: should be null or not yet ended
                $query->whereNull('ended_at')
                      ->orWhere('ended_at', '>=', now());
            })
            ->inRandomOrder()
            ->take(5)
            ->get();

        return view('dashboard', compact('user', 'recommendations', 'exploreProducts', 'promoProducts', 'banners'));
    }
}
