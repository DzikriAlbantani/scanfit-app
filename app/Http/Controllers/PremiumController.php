<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PremiumController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $limit = (int)config('scan.free_limit', 10);
        $used = $user ? $user->scans()->count() : 0;
        $remaining = max(0, $limit - $used);

        return view('premium.index', compact('remaining', 'limit', 'used', 'user'));
    }

    public function activate(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return redirect()->route('login');
        }
        $user->is_premium = true;
        $user->save();

        Log::info('User upgraded to premium', ['user_id' => $user->id]);

        return redirect()->route('scan.index')->with('success', 'Akun Anda telah di-upgrade ke Premium!');
    }
}
