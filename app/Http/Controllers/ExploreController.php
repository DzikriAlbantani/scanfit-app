<?php

namespace App\Http\Controllers;

use App\Models\FashionItem;
use Illuminate\Http\Request;

class ExploreController extends Controller
{
    public function index(Request $request)
    {
        $query = FashionItem::whereHas('brand', function ($q) {
            $q->where('status', 'approved');
        });

        // Search Logic
        if ($request->has('search') && !empty($request->search)) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . request('search') . '%')
                  ->orWhere('description', 'like', '%' . request('search') . '%');
            });
        }

        // Category Logic - Filter by product type (Atasan, Bawahan, etc)
        if ($request->has('category') && !empty($request->category) && $request->category !== 'Semua') {
            $query->where('category', $request->category);
        }

        // Price Range Filter
        if ($request->has('min_price') && !empty($request->min_price)) {
            $query->where('price', '>=', (int)$request->min_price);
        }
        if ($request->has('max_price') && !empty($request->max_price)) {
            $query->where('price', '<=', (int)$request->max_price);
        }

        // Sorting Logic
        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        // Pagination
        $items = $query->paginate(12)->withQueryString();

        // Product type categories
        $categories = ['Semua', 'Atasan', 'Bawahan', 'Aksesoris', 'Outwear', 'Dress', 'Shoes'];

        return view('explore', compact('items', 'categories'));
    }
}
