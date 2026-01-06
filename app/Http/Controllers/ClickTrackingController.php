<?php

namespace App\Http\Controllers;

use App\Models\FashionItem;
use App\Models\ClickEvent;
use Illuminate\Http\Request;

class ClickTrackingController extends Controller
{
    public function trackClick(Request $request, FashionItem $fashionItem)
    {
        // Increment aggregate counter for quick lookup
        $fashionItem->increment('clicks_count');

        // Store granular click event for analytics (time-series)
        ClickEvent::create([
            'fashion_item_id' => $fashionItem->id,
            'user_id' => $request->user()?->id,
            'source' => $request->input('source', 'unknown'),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json(['success' => true]);
    }
}
