<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BrandBanner;
use Illuminate\Http\Request;

class BannerAdminController extends Controller
{
    public function __construct()
    {
        // Authorization check via middleware in routes
    }

    /**
     * View All Banners
     */
    public function index(Request $request)
    {
        $query = BrandBanner::with('brand.user');

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $query->where('title', 'like', "%{$request->search}%")
                  ->orWhereHas('brand', function ($q) {
                      $q->where('brand_name', 'like', "%{$request->search}%");
                  });
        }

        $banners = $query->latest('created_at')->paginate(20);

        $stats = [
            'total_banners' => BrandBanner::count(),
            'pending_banners' => BrandBanner::where('status', 'pending')->count(),
            'approved_banners' => BrandBanner::where('status', 'approved')->count(),
            'active_banners' => BrandBanner::where('status', 'active')->count(),
            'total_clicks' => BrandBanner::sum('clicks'),
        ];

        return view('admin.banners.index', compact('banners', 'stats'));
    }

    /**
     * View Banner Details
     */
    public function show(BrandBanner $banner)
    {
        return view('admin.banners.show', compact('banner'));
    }

    /**
     * Approve Banner
     */
    public function approve(BrandBanner $banner)
    {
        $banner->update([
            'status' => 'approved',
        ]);

        return redirect()->back()->with('success', 'Banner berhasil disetujui');
    }

    /**
     * Activate Banner
     */
    public function activate(BrandBanner $banner)
    {
        $banner->update([
            'status' => 'active',
        ]);

        return redirect()->back()->with('success', 'Banner berhasil diaktifkan');
    }

    /**
     * Deactivate Banner
     */
    public function deactivate(BrandBanner $banner)
    {
        $banner->update([
            'status' => 'inactive',
        ]);

        return redirect()->back()->with('success', 'Banner berhasil dinonaktifkan');
    }

    /**
     * Reject Banner
     */
    public function reject(Request $request, BrandBanner $banner)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);

        $banner->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        return redirect()->back()->with('success', 'Banner berhasil ditolak');
    }

    /**
     * Delete Banner
     */
    public function delete(BrandBanner $banner)
    {
        $banner->delete();

        return redirect()->route('admin.banners.index')->with('success', 'Banner berhasil dihapus');
    }
}
