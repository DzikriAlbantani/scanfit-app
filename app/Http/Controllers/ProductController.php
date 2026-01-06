<?php

namespace App\Http\Controllers;

use App\Models\FashionItem;
use App\Models\ClickEvent;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(FashionItem $item)
    {
        // Increment click count for analytics
        $item->increment('clicks_count');

        // Log granular click event for time-series analytics
        ClickEvent::create([
            'fashion_item_id' => $item->id,
            'user_id' => request()->user()?->id,
            'source' => 'product_page',
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        // More from same brand (exclude current item)
        $moreFromBrand = FashionItem::where('brand_id', $item->brand_id)
            ->where('id', '!=', $item->id)
            ->whereHas('brand', function ($q) {
                $q->where('status', 'approved');
            })
            ->take(4)
            ->get();

        // Similar styles from different brands (exclude current item)
        $similarStyles = FashionItem::where('category', $item->category)
            ->where('brand_id', '!=', $item->brand_id)
            ->where('id', '!=', $item->id)
            ->whereHas('brand', function ($q) {
                $q->where('status', 'approved');
            })
            ->take(4)
            ->get();

        // Check if user has already saved this item
        $isSaved = false;
        if (request()->user()) {
            $isSaved = request()->user()->closetItems()
                ->where('fashion_item_id', $item->id)
                ->exists();
        }

        return view('products.show', compact('item', 'moreFromBrand', 'similarStyles', 'isSaved'));
    }

    /**
     * Track click event via AJAX (optional - for tracking without page navigation)
     */
    public function trackClick(Request $request, FashionItem $item)
    {
        $item->increment('clicks_count');

        ClickEvent::create([
            'fashion_item_id' => $item->id,
            'user_id' => $request->user()?->id,
            'source' => $request->input('source', 'ajax'),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
        
        return response()->json([
            'success' => true,
            'clicks' => $item->clicks_count
        ]);
    }
}
