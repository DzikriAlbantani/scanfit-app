<?php

namespace App\Http\Controllers\Brand;

use App\Http\Controllers\Controller;
use App\Models\BrandBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function __construct()
    {
        // Authorization check in routes or use middleware groups
    }

    /**
     * Banner Management List
     */
    public function index(Request $request)
    {
        $brand = auth()->user()->brand;
        
        if (!$brand) {
            return redirect()->route('brand.pending');
        }

        $query = $brand->banners();

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $banners = $query->latest('created_at')->paginate(10);
        
        $stats = [
            'total_banners' => $brand->banners()->count(),
            'active_banners' => $brand->banners()->where('status', 'active')->count(),
            'pending_banners' => $brand->banners()->where('status', 'pending')->count(),
            'total_clicks' => $brand->banners()->sum('clicks'),
            'total_impressions' => $brand->banners()->sum('impressions'),
        ];

        return view('brand.banners.index', compact('banners', 'stats'));
    }

    /**
     * Create New Banner
     */
    public function create()
    {
        return view('brand.banners.create');
    }

    /**
     * Store New Banner
     */
    public function store(Request $request)
    {
        $brand = auth()->user()->brand;
        
        if (!$brand) {
            return redirect()->route('brand.pending');
        }

        $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'banner_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'link_url' => 'nullable|url',
            'cta_text' => 'required|string|max:50',
            'started_at' => 'nullable|date|after:today',
            'ended_at' => 'nullable|date|after:started_at',
            'budget' => 'nullable|numeric|min:0',
        ]);

        $bannerPath = $request->file('banner_image')->store('brand-banners', 'public');

        BrandBanner::create([
            'brand_id' => $brand->id,
            'title' => $request->title,
            'description' => $request->description,
            'banner_image_url' => $bannerPath,
            'link_url' => $request->link_url,
            'cta_text' => $request->cta_text,
            'started_at' => $request->started_at,
            'ended_at' => $request->ended_at,
            'budget' => $request->budget,
            'status' => 'pending',
        ]);

        return redirect()->route('brand.banners.index')->with('success', 'Banner berhasil dibuat dan menunggu approval dari admin');
    }

    /**
     * Edit Banner
     */
    public function edit(BrandBanner $banner)
    {
        if ($banner->brand_id !== auth()->user()->brand?->id) {
            abort(403, 'Unauthorized');
        }
        
        return view('brand.banners.edit', compact('banner'));
    }

    /**
     * Update Banner
     */
    public function update(Request $request, BrandBanner $banner)
    {
        if ($banner->brand_id !== auth()->user()->brand?->id) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'link_url' => 'nullable|url',
            'cta_text' => 'required|string|max:50',
            'started_at' => 'nullable|date',
            'ended_at' => 'nullable|date',
            'budget' => 'nullable|numeric|min:0',
        ]);

        $data = $request->only(['title', 'description', 'link_url', 'cta_text', 'started_at', 'ended_at', 'budget']);

        if ($request->hasFile('banner_image')) {
            if ($banner->banner_image_url) {
                Storage::disk('public')->delete($banner->banner_image_url);
            }
            $data['banner_image_url'] = $request->file('banner_image')->store('brand-banners', 'public');
        }

        $banner->update($data);

        return redirect()->route('brand.banners.index')->with('success', 'Banner berhasil diperbarui');
    }

    /**
     * View Banner Details
     */
    public function show(BrandBanner $banner)
    {
        if ($banner->brand_id !== auth()->user()->brand?->id) {
            abort(403, 'Unauthorized');
        }
        
        return view('brand.banners.show', compact('banner'));
    }

    /**
     * Delete Banner
     */
    public function delete(BrandBanner $banner)
    {
        if ($banner->brand_id !== auth()->user()->brand?->id) {
            abort(403, 'Unauthorized');
        }

        if ($banner->banner_image_url) {
            Storage::disk('public')->delete($banner->banner_image_url);
        }

        $banner->delete();

        return redirect()->route('brand.banners.index')->with('success', 'Banner berhasil dihapus');
    }
}
