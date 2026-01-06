<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function show(Brand $brand)
    {
        // Load approved products
        $products = $brand->fashionItems()->whereHas('brand', function ($q) {
            $q->where('status', 'approved');
        })->paginate(12);

        return view('brand.show', compact('brand', 'products'));
    }
}
