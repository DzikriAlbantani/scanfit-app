<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureBrandIsApproved
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        \Log::info('EnsureBrandIsApproved middleware: user id ' . ($user ? $user->id : 'null'));

        if (!$user) {
            \Log::info('User not authenticated');
            abort(403, 'Access denied. Only brand owners can access this page.');
        }

        $brand = $user->brand;
        \Log::info('Brand: ' . ($brand ? $brand->id : 'null'));

        if (!$brand) {
            \Log::info('No brand found, redirect to register');
            return redirect()->route('brand.register')->with('error', 'Brand profile not found.');
        }

        if ($brand->isPending()) {
            \Log::info('Brand pending');
            return redirect()->route('brand.pending');
        }

        if ($brand->isRejected()) {
            \Log::info('Brand rejected');
            return redirect()->route('brand.rejected');
        }

        \Log::info('Brand approved, proceeding');
        return $next($request);
    }
}
