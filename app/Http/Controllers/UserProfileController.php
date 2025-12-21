<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        
        // 2. Ambil data profil (relasi) dengan null safety
        $profile = $user->profile ?? null; // Jika belum ada profil, kirim null

        // 3. Ambil data scans dan likes (asumsikan relasi ada)
        $scans = $user->scans()->latest()->paginate(10); // Paginate untuk performa
        $likes = $user->likes()->latest()->paginate(10);

        // 4. Kirim variabel ke View
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
            'bio' => ['nullable', 'string', 'max:500'],
            'style_preference' => ['nullable', 'string'],
            'skin_tone' => ['nullable', 'string'],
            'body_size' => ['nullable', 'string'],
            'height' => ['nullable', 'numeric'],
            'weight' => ['nullable', 'numeric'],
            'favorite_colors' => ['nullable', 'array'],
        ]);

        $userId = Auth::id();

        if (!$userId) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $user->name = $validated['name'];
        $user->save();

        // Handle favorite_colors
        $validated['favorite_color'] = isset($validated['favorite_colors']) ? implode(',', $validated['favorite_colors']) : '';
        unset($validated['favorite_colors']);

        // Update or create profile
        $profileData = array_diff_key($validated, ['name' => '']); // Remove name from profile data
        UserProfile::updateOrCreate(
            ['user_id' => $userId],
            $profileData
        );

        return redirect()->route('profile.index')->with('status', 'Profile updated successfully.');
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

        // Map style_preference values
        $styleMapping = [
            'Casual' => 'casual',
            'Formal' => 'formal',
            'Sporty' => 'sport',
            'Streetwear' => 'street',
            'Vintage' => 'vintage',
            'Minimalist' => 'minimal',
            // For others, default to 'casual' or handle accordingly
            'Korean' => 'casual',
            'Bohemian' => 'casual',
        ];
        if (isset($styleMapping[$validated['style_preference']])) {
            $validated['style_preference'] = $styleMapping[$validated['style_preference']];
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
