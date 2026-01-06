<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\UserProfile;

class UserProfileController extends Controller
{
    /**
     * Display the user's profile page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // 1. Ambil user yang sedang login
        $user = Auth::user();
        
        // Force refresh to get latest subscription data from database
        if ($user) {
            $user->refresh();
            // Update session with refreshed user
            Auth::setUser($user);
        }
        
        // 2. Ambil data profil (relasi) dengan null safety
        $profile = $user->profile ?? null; // Jika belum ada profil, kirim null

        // 3. Ambil data scans dan likes (asumsikan relasi ada)
        $scans = $user->scans()->latest()->paginate(10); // Paginate untuk performa
        $likes = $user->likes()->latest()->paginate(10);

        // 3b. Hitung metrik penggunaan untuk kartu ringkasan
        $scanCount = $user->scans()->count();
        $savedCount = $user->closetItems()->count();
        $likeCount  = $user->likes()->count();

        // 3c. Kumpulkan aktivitas terbaru (like & simpan closet)
        $recentLikes = $user->likes()
            ->select(['id', 'item_name', 'type', 'created_at'])
            ->latest()
            ->take(15)
            ->get()
            ->toBase()
            ->map(function ($like) {
                return [
                    'id' => $like->id,
                    'title' => $like->item_name ?? 'Item',
                    'type' => $like->type ?: 'like',
                    'kind' => 'like',
                    'created_at' => $like->created_at,
                    'url' => null,
                ];
            });

        $recentSaves = $user->closetItems()
            ->select(['id', 'name', 'created_at'])
            ->latest()
            ->take(15)
            ->get()
            ->toBase()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->name ?? 'Item tersimpan',
                    'type' => 'saved',
                    'kind' => 'saved',
                    'created_at' => $item->created_at,
                    'url' => route('closet.index'),
                ];
            });

        $activities = $recentLikes
            ->merge($recentSaves)
            ->sortByDesc('created_at')
            ->values();

        // 4. Kirim variabel ke View
        return view('profile.index', compact('user', 'profile', 'scans', 'likes', 'scanCount', 'savedCount', 'likeCount', 'activities'));
    }

    /**
     * Show the form for editing the user's profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $user = Auth::user()->load(['scans' => function ($query) {
            $query->latest()->take(10);
        }, 'likes' => function ($query) {
            $query->with('product')->latest()->take(10);
        }]);

        $profile = $user->profile;

        return view('profile.index', compact('user', 'profile', 'scans', 'likes'));
    }

    /**
     * Show the onboarding setup form.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('profile.setup');
    }

    /**
     * Update the authenticated user's profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'bio' => ['nullable', 'string', 'max:500'],
            'style_preference' => ['nullable', 'string'],
            'skin_tone' => ['nullable', 'string'],
            'body_size' => ['nullable', 'string'],
            'height' => ['nullable', 'numeric'],
            'weight' => ['nullable', 'numeric'],
            'favorite_colors' => ['nullable', 'array'],
        ]);

        $user = Auth::user();

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            // Store new avatar
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->profile_photo_path = $path;
        }

        // Update user name
        $user->name = $validated['name'];
        $user->save();

        // Handle favorite_colors
        $validated['favorite_color'] = isset($validated['favorite_colors']) ? implode(',', $validated['favorite_colors']) : '';
        unset($validated['favorite_colors']);

        // Update or create profile
        $profileData = array_diff_key($validated, ['name' => '', 'avatar' => '']); // Remove name and avatar from profile data
        UserProfile::updateOrCreate(
            ['user_id' => $user->id],
            $profileData
        );

        return redirect()->back()->with('status', 'profile-updated');
    }

    /**
     * Store or update the authenticated user's profile from onboarding.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'max:50'],
            'style_preference' => ['required', 'string', 'max:255'],
            'skin_tone' => ['required', 'string', 'max:100'],
            'body_size' => ['required', 'string', 'max:100'],
            'favorite_color' => ['required', 'string', 'max:100'],
            'main_need' => ['required', 'string', 'max:255'],
        ]);

        // Map gender values to English
        $genderMapping = [
            'Pria' => 'male',
            'Wanita' => 'female',
            'Unisex' => 'other',
        ];
        if (isset($genderMapping[$validated['gender']])) {
            $validated['gender'] = $genderMapping[$validated['gender']];
        }

        // Map style_preference values to canonical slugs used across scans/products
        $styleMapping = [
            'casual' => 'casual',
            'Casual' => 'casual',
            'Formal' => 'formal',
            'formal' => 'formal',
            'Sporty' => 'sport',
            'sporty' => 'sport',
            'Sport' => 'sport',
            'sport' => 'sport',
            'Streetwear' => 'street',
            'streetwear' => 'street',
            'Street' => 'street',
            'street' => 'street',
            'Vintage' => 'vintage',
            'vintage' => 'vintage',
            'Minimalist' => 'minimal',
            'minimalist' => 'minimal',
            'Minimal' => 'minimal',
            'minimal' => 'minimal',
            'Korean Style' => 'street',
            'Korean' => 'street',
            'Bohemian' => 'vintage',
        ];
        if (isset($styleMapping[$validated['style_preference']])) {
            $validated['style_preference'] = $styleMapping[$validated['style_preference']];
        }

        // Final guard: only allow known styles
        $allowedStyles = ['casual', 'formal', 'street', 'vintage', 'minimal', 'sport'];
        if (!in_array($validated['style_preference'], $allowedStyles, true)) {
            $validated['style_preference'] = 'casual';
        }

        // Map skin_tone values
        $skinToneMapping = [
            'Fair' => 'light',
            'Medium' => 'medium',
            'Olive' => 'tan',
            'Dark' => 'dark',
        ];
        if (isset($skinToneMapping[$validated['skin_tone']])) {
            $validated['skin_tone'] = $skinToneMapping[$validated['skin_tone']];
        }

        // Map body_size values
        $bodySizeMapping = [
            'Slim' => 'S',
            'Medium' => 'M',
            'Plus' => 'L', // Assuming Plus maps to L
        ];
        if (isset($bodySizeMapping[$validated['body_size']])) {
            $validated['body_size'] = $bodySizeMapping[$validated['body_size']];
        }

        $userId = Auth::id();

        // Ensure user is authenticated
        if (!$userId) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $user->name = $validated['name'];
        $user->save();

        // Remove name from data for UserProfile
        unset($validated['name']);

        // Attach user_id and create or update the profile
        $data = array_merge($validated, ['user_id' => $userId]);

        UserProfile::updateOrCreate(
            ['user_id' => $userId],
            $data
        );

        return redirect()->route('dashboard');
    }
}
