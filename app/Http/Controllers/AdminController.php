<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\User;
use App\Models\FashionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Admin Dashboard
     */
    public function dashboard()
    {
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'total_brands' => Brand::count(),
            'pending_brands' => Brand::where('status', 'pending')->count(),
            'approved_brands' => Brand::where('status', 'approved')->count(),
            'rejected_brands' => Brand::where('status', 'rejected')->count(),
            'total_products' => FashionItem::count(),
            'premium_users' => User::where('is_premium', true)->count(),
        ];

        $recentUsers = User::where('role', 'user')
            ->latest('created_at')
            ->take(10)
            ->get();

        $recentBrands = Brand::with('user')
            ->latest('created_at')
            ->take(10)
            ->get();

        // Banner Statistics
        $bannerStats = [
            'total' => \App\Models\BrandBanner::count(),
            'pending' => \App\Models\BrandBanner::where('status', 'pending')->count(),
            'active' => \App\Models\BrandBanner::where('status', 'active')->count(),
            'rejected' => \App\Models\BrandBanner::where('status', 'rejected')->count(),
            'total_clicks' => \App\Models\BrandBanner::sum('clicks'),
            'total_impressions' => \App\Models\BrandBanner::sum('impressions'),
        ];

        // Pending Banners for Review
        $pendingBanners = \App\Models\BrandBanner::with('brand')
            ->where('status', 'pending')
            ->latest('created_at')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentBrands', 'bannerStats', 'pendingBanners'));
    }

    /**
     * Manage Users
     */
    public function users(Request $request)
    {
        $query = User::where('role', 'user');

        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
        }

        if ($request->filter === 'premium') {
            $query->where('is_premium', true);
        } elseif ($request->filter === 'free') {
            $query->where('is_premium', false);
        }

        $users = $query->latest('created_at')->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    /**
     * View User Details
     */
    public function userShow(User $user)
    {
        if ($user->role !== 'user') {
            abort(404);
        }

        $closetItems = $user->closetItems()->count();
        $albums = $user->albums()->count();

        return view('admin.users.show', compact('user', 'closetItems', 'albums'));
    }

    /**
     * Disable/Enable User
     */
    public function toggleUserStatus(User $user)
    {
        if ($user->role !== 'user') {
            abort(404);
        }

        $user->update([
            'is_active' => !($user->is_active ?? true)
        ]);

        return redirect()->back()->with('success', 'User status updated');
    }

    /**
     * Delete User
     */
    public function deleteUser(User $user)
    {
        if ($user->role !== 'user' || $user->id === auth()->id()) {
            abort(403);
        }

        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User deleted successfully');
    }

    /**
     * Manage Brands
     */
    public function brands(Request $request)
    {
        $query = Brand::with('user');

        if ($request->search) {
            $query->where('brand_name', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%")
                  ->orWhereHas('user', function ($q) {
                      $q->where('name', 'like', "%{$request->search}%");
                  });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $brands = $query->latest('created_at')->paginate(20);

        $stats = [
            'pending' => Brand::where('status', 'pending')->count(),
            'approved' => Brand::where('status', 'approved')->count(),
            'rejected' => Brand::where('status', 'rejected')->count(),
        ];

        return view('admin.brands.index', compact('brands', 'stats'));
    }

    /**
     * Brand Approval
     */
    public function approveBrand(Brand $brand)
    {
        $brand->update([
            'status' => 'approved',
            'verified' => true
        ]);

        // Mark user as brand owner
        $brand->user->update(['role' => 'brand_owner']);

        return redirect()->back()->with('success', 'Brand approved successfully!');
    }

    /**
     * Brand Rejection
     */
    public function rejectBrand(Brand $brand)
    {
        $brand->update([
            'status' => 'rejected',
            'verified' => false
        ]);

        return redirect()->back()->with('success', 'Brand rejected successfully!');
    }

    /**
     * View Brand Details
     */
    public function brandShow(Brand $brand)
    {
        $products = $brand->fashionItems()->count();
        $owner = $brand->user;

        return view('admin.brands.show', compact('brand', 'products', 'owner'));
    }

    /**
     * Delete Brand
     */
    public function deleteBrand(Brand $brand)
    {
        $owner = $brand->user;
        $brand->delete();

        // Reset user role to user
        $owner->update(['role' => 'user']);

        return redirect()->route('admin.brands')->with('success', 'Brand deleted successfully');
    }

    /**
     * System Settings
     */
    public function settings()
    {
        return view('admin.settings');
    }

    /**
     * Activity Logs
     */
    public function logs(Request $request)
    {
        // Implementasi akan menampilkan activity logs
        $logs = [];
        
        return view('admin.logs', compact('logs'));
    }
}
