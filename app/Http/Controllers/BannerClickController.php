<?php

namespace App\Http\Controllers;

use App\Models\BrandBanner;
use Illuminate\Http\Request;

class BannerClickController extends Controller
{
    /**
     * Record banner click and redirect to target URL
     */
    public function click(BrandBanner $banner)
    {
        // Record the click
        $banner->recordClick();

        // If banner has a link_url, redirect to it
        if ($banner->link_url) {
            return redirect($banner->link_url);
        }

        // Fallback to home if no link
        return redirect('/');
    }

    /**
     * Record impression (when banner is viewed/displayed)
     */
    public function recordImpression(Request $request)
    {
        $bannerId = $request->input('banner_id');
        $banner = BrandBanner::find($bannerId);

        if ($banner) {
            $banner->recordImpression();
            return response()->json(['success' => true, 'impressions' => $banner->impressions]);
        }

        return response()->json(['success' => false], 404);
    }
}
