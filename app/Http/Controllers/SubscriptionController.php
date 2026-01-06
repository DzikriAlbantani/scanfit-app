<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Show subscription info and current benefits
     */
    public function info(Request $request)
    {
        return view('subscription.info');
    }

    /**
     * Mock upgrade: update subscription_plan and is_premium.
     */
    public function upgrade(Request $request, string $plan)
    {
        $plan = strtolower($plan);
        $valid = ['basic', 'plus', 'pro'];
        if (!in_array($plan, $valid, true)) {
            return redirect()->back()->with('error', 'Paket tidak valid.');
        }

        $user = $request->user();
        if (!$user) {
            return redirect()->route('login');
        }

        $user->subscription_plan = $plan;
        // Mark as premium if plan is plus or pro
        if (in_array($plan, ['plus', 'pro'])) {
            $user->is_premium = true;
            $user->subscription_expires_at = now()->addMonth();
        } else {
            $user->is_premium = false;
            $user->subscription_expires_at = null;
        }
        $user->save();

        return redirect()->back()->with('success', 'Berhasil upgrade ke paket: ' . ucfirst($plan));
    }
}
