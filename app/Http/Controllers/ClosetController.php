<?php

namespace App\Http\Controllers;

use App\Models\ClosetItem;
use App\Models\FashionItem;
use App\Models\OutfitAlbum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClosetController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        // Get all albums for this user
        $albums = OutfitAlbum::where('user_id', $userId)
            ->withCount('items')
            ->latest()
            ->get();

        // Get items not in any album
        $query = ClosetItem::where('user_id', $userId)
            ->whereNull('outfit_album_id');

        // Handle search
        if ($request->has('search') && !empty($request->search)) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Handle category filter
        if ($request->has('category') && !empty($request->category) && $request->category !== 'Semua') {
            $query->where('category', $request->category);
        }

        $items = $query->latest()->paginate(12);

        // Calculate category counts
        $categoryCounts = ClosetItem::where('user_id', $userId)
            ->whereNull('outfit_album_id')
            ->selectRaw('category, COUNT(*) as count')
            ->groupBy('category')
            ->pluck('count', 'category')
            ->toArray();

        $totalItems = ClosetItem::where('user_id', $userId)->count();

        return view('closet.index', compact('items', 'categoryCounts', 'totalItems', 'albums'));
    }

    public function createAlbum(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $userId = Auth::id();

        OutfitAlbum::create([
            'user_id' => $userId,
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('closet.index')->with('success', 'Album outfit berhasil dibuat!');
    }

    public function viewAlbum(OutfitAlbum $album)
    {
        if ($album->user_id !== Auth::id()) {
            abort(403);
        }

        $items = $album->items()->latest()->paginate(12);
        $albums = OutfitAlbum::where('user_id', Auth::id())
            ->withCount('items')
            ->latest()
            ->get();

        return view('closet.album', compact('album', 'items', 'albums'));
    }

    public function updateAlbum(Request $request, OutfitAlbum $album)
    {
        if ($album->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $album->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Album berhasil diperbarui!');
    }

    public function destroyAlbum(OutfitAlbum $album)
    {
        if ($album->user_id !== Auth::id()) {
            abort(403);
        }

        // Move items back to unassigned
        $album->items()->update(['outfit_album_id' => null]);
        $album->delete();

        return redirect()->route('closet.index')->with('success', 'Album berhasil dihapus!');
    }

    public function addItemToAlbum(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:closet_items,id',
            'album_id' => 'required|exists:outfit_albums,id',
        ]);

        $userId = Auth::id();
        $item = ClosetItem::findOrFail($request->item_id);
        $album = OutfitAlbum::findOrFail($request->album_id);

        // Cek ownership
        if ($item->user_id !== $userId || $album->user_id !== $userId) {
            return response()->json(['message' => 'Unauthorized', 'error' => true], 403);
        }

        $item->update(['outfit_album_id' => $album->id]);

        return response()->json(['message' => 'Item berhasil ditambahkan ke album!', 'success' => true]);
    }

    public function removeItemFromAlbum(Request $request, ClosetItem $item)
    {
        if ($item->user_id !== Auth::id()) {
            abort(403);
        }

        $item->update(['outfit_album_id' => null]);

        return redirect()->back()->with('success', 'Item berhasil dihapus dari album!');
    }

    public function store(Request $request)
    {
        // Enforce subscription quota for closet items
        $user = Auth::user();
        if ($user && !$user->hasQuotaFor('closet')) {
            return redirect()->route('pricing.index')
                ->with('error', 'Kuota habis! Upgrade untuk akses lebih.');
        }

        $request->validate([
            'fashion_item_id' => 'nullable|exists:fashion_items,id',
            'image_url' => 'required|string',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|in:Casual,Streetwear,Formal,Sporty,Vintage,Minimalist',
        ]);

        $userId = Auth::id();

        ClosetItem::create([
            'user_id' => $userId,
            'fashion_item_id' => $request->fashion_item_id,
            'image_url' => $request->image_url,
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
        ]);

        return redirect()->back()->with('success', 'Item berhasil ditambahkan ke closet!');
    }

    public function update(Request $request, ClosetItem $closetItem)
    {
        // Ensure user owns the item
        if ($closetItem->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $closetItem->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Item berhasil diperbarui!');
    }

    public function destroy(ClosetItem $closetItem)
    {
        // Ensure user owns the item
        if ($closetItem->user_id !== Auth::id()) {
            abort(403);
        }

        $closetItem->delete();

        return redirect()->back()->with('success', 'Item berhasil dihapus dari closet!');
    }

    public function save(Request $request)
    {
        \Log::info('ClosetController save called', [
            'user_authenticated' => Auth::check(),
            'user_id' => Auth::id(),
            'request_data' => $request->all()
        ]);

        if (!Auth::check()) {
            \Log::info('User not authenticated for closet save');
            return response()->json([
                'message' => 'Anda harus login terlebih dahulu untuk menyimpan item ke closet!'
            ], 401);
        }

        // Enforce subscription quota for closet items (AJAX)
        $user = Auth::user();
        if ($user && !$user->hasQuotaFor('closet')) {
            return response()->json([
                'message' => 'Kuota habis! Upgrade untuk akses lebih.',
                'redirect' => route('pricing.index'),
            ], 403);
        }

        $request->validate([
            'item_id' => 'required|exists:fashion_items,id',
        ]);

        $userId = Auth::id();
        $fashionItem = FashionItem::findOrFail($request->item_id);

        \Log::info('Fashion item found', ['item_id' => $fashionItem->id, 'item_name' => $fashionItem->name]);

        // Check if item is already in closet
        $existingItem = ClosetItem::where('user_id', $userId)
            ->where('fashion_item_id', $fashionItem->id)
            ->first();

        if ($existingItem) {
            \Log::info('Item already exists in closet');
            return response()->json([
                'message' => 'Item sudah ada di closet Anda!'
            ], 409);
        }

        $closetItem = ClosetItem::create([
            'user_id' => $userId,
            'fashion_item_id' => $fashionItem->id,
            'image_url' => $fashionItem->image_url,
            'name' => $fashionItem->name,
            'description' => $fashionItem->description,
            'category' => $fashionItem->category,
        ]);

        \Log::info('Closet item created successfully', ['closet_item_id' => $closetItem->id]);

        return response()->json([
            'message' => 'Item berhasil disimpan ke closet!'
        ]);
    }
}

