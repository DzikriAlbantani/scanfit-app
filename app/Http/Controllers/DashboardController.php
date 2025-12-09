<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil user yang sedang login
        $user = Auth::user();

        // 2. Ambil 4 produk secara acak untuk recommendations
        $recommendations = Product::inRandomOrder()->take(4)->get();

        // 3. Ambil 8 produk secara acak untuk grid explore
        $exploreProducts = Product::inRandomOrder()->take(8)->get();

        // 4. Ambil 3 produk acak untuk widget bawah (Flash Sale, New Arrivals, Best Sellers)
        $promoProducts = Product::inRandomOrder()->take(3)->get();

        return view('dashboard', compact('user', 'recommendations', 'exploreProducts', 'promoProducts'));
    }
}
