<x-layout>
    <x-slot:title>Lemari Pakaianku - Album Outfit</x-slot:title>

    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-slide-in {
            animation: slideIn 0.3s ease-out;
        }
    </style>

    <div x-data="closetApp()" class="min-h-screen bg-slate-50">
        <section class="relative overflow-hidden bg-white pb-12 pt-48 border-b border-slate-200">
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-50 rounded-full blur-3xl opacity-60 -mr-20 -mt-20 pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="space-y-4 text-center md:text-left">
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                        Lemari <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">Pakaianku</span>
                    </h1>
                    <p class="text-base text-slate-600 max-w-2xl mx-auto md:mx-0">
                        Organisir koleksi fashion dengan album outfit yang rapi dan terstruktur.
                    </p>
                </div>

                <div class="mt-8 flex flex-col md:flex-row gap-4 items-center justify-between">
                    @php
                        $user = auth()->user();
                        $isPremium = $user?->isPremium();
                        $itemCount = $user ? $user->closetItems()->count() : 0;
                        $plan = $user?->subscription_plan ?? 'basic';
                        $limits = config('pricing.plans.' . $plan . '.features.closet_items') ?? 15;
                        $itemLimit = $limits === 'unlimited' ? 'unlimited' : $limits;
                    @endphp

                    @if(!$isPremium && $itemCount >= ($itemLimit ?? 15))
                    <div class="w-full bg-amber-50 border-2 border-amber-200 rounded-xl p-4 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-amber-100 text-amber-700">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/></svg>
                            </span>
                            <div>
                                <p class="font-bold text-amber-900">Limit Item Tercapai</p>
                                <p class="text-sm text-amber-800">Upgrade ke Premium untuk menambah item tak terbatas</p>
                            </div>
                        </div>
                        <a href="{{ route('pricing.index') }}" class="px-4 py-2 rounded-lg bg-amber-600 text-white font-bold text-sm hover:bg-amber-700 transition-colors whitespace-nowrap">
                            Upgrade
                        </a>
                    </div>
                    @elseif(!$isPremium)
                    <div class="w-full bg-blue-50 border border-blue-200 rounded-xl p-4 flex items-center justify-between">
                        <div class="flex items-center gap-3 flex-1">
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-100 text-blue-700 flex-shrink-0">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z"/></svg>
                            </span>
                            <div>
                                <p class="font-semibold text-blue-900">{{ $itemCount }} / {{ $itemLimit }} Item</p>
                                <p class="text-xs text-blue-800">Paket Gratis: {{ $itemLimit }} item</p>
                            </div>
                        </div>
                        <a href="{{ route('pricing.index') }}" class="px-4 py-2 rounded-lg bg-blue-600 text-white font-bold text-sm hover:bg-blue-700 transition-colors whitespace-nowrap">
                            Upgrade
                        </a>
                    </div>
                    @else
                    <div class="w-full bg-emerald-50 border border-emerald-200 rounded-xl p-4 flex items-center gap-3">
                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-emerald-100 text-emerald-700 flex-shrink-0">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        </span>
                        <div>
                            <p class="font-semibold text-emerald-900">{{ $itemCount }} / ∞ Item</p>
                            <p class="text-xs text-emerald-800">Paket Premium: Item tak terbatas</p>
                        </div>
                    </div>
                    @endif

                    <div class="flex gap-3 w-full md:w-auto">
                        <button @click="showNewAlbumModal=true" class="flex items-center gap-2 px-6 py-3 bg-slate-900 text-white rounded-full font-bold text-sm hover:bg-slate-800 transition-all shadow-sm whitespace-nowrap flex-1 md:flex-none justify-center md:justify-start">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Album Baru
                        </button>
                        <a href="{{ route('explore.index') }}" class="flex items-center gap-2 px-6 py-3 bg-white border border-slate-200 text-slate-700 rounded-full font-bold text-sm hover:bg-slate-50 transition-all shadow-sm whitespace-nowrap flex-1 md:flex-none justify-center md:justify-start">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah Item
                        </a>
                    </div>

                    {{-- STATS --}}
                    <div class="flex gap-4 items-center text-sm font-medium text-slate-600">
                        <span>Total: <span class="text-slate-900 font-bold">{{ $totalItems ?? 0 }}</span></span>
                        <span>Album: <span class="text-slate-900 font-bold">{{ count($albums) }}</span></span>
                        <span>Unassigned: <span class="text-slate-900 font-bold">{{ ($items->total() ?? 0) }}</span></span>
                    </div>
                </div>
            </div>
        </section>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">


            {{-- ALBUMS SECTION --}}
            @if(count($albums) > 0)
            <div class="mb-16">
                <h2 class="text-2xl font-extrabold text-slate-900 mb-8">Album Outfit</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($albums as $album)
                    <a href="{{ route('closet.album.view', $album) }}" class="group bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 flex flex-col overflow-hidden">
                        {{-- Album Cover (Grid dari item) --}}
                        <div class="relative h-48 bg-slate-100 overflow-hidden">
                            @if($album->items->count() > 0)
                                <div class="grid grid-cols-2 gap-0 h-full">
                                    @foreach($album->items->take(4) as $idx => $item)
                                    <div class="overflow-hidden {{ $idx === 0 ? 'col-span-2 row-span-2' : '' }}">
                                        <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-300">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                        </div>

                        {{-- Album Info --}}
                        <div class="p-4">
                            <h3 class="text-base font-bold text-slate-900 group-hover:text-blue-600 transition-colors line-clamp-1 mb-1">{{ $album->name }}</h3>
                            @if($album->description)
                            <p class="text-sm text-slate-600 line-clamp-1 mb-3">{{ $album->description }}</p>
                            @endif
                            
                            <div class="flex items-center justify-between pt-3 border-t border-slate-200">
                                <span class="text-xs font-semibold text-slate-700">{{ $album->items_count }} item</span>
                                <span class="text-xs text-slate-400">{{ $album->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- UNASSIGNED ITEMS SECTION --}}
            <div>
                <h2 class="text-2xl font-extrabold text-slate-900 mb-8">Item Tanpa Album</h2>

                {{-- SEARCH & FILTER --}}
                <div class="mt-8 flex flex-col md:flex-row gap-4 items-center justify-between mb-8">
                    
                    <form action="{{ route('closet.index') }}" method="GET" class="relative w-full md:max-w-md group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400 group-focus-within:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari item pakaian..."
                               class="block w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-full text-base text-slate-900 placeholder-slate-400 focus:border-slate-900 focus:ring-0 transition-all shadow-sm hover:border-slate-300">
                    </form>

                    {{-- Category Filter --}}
                    <div class="flex gap-2 overflow-x-auto no-scrollbar w-full md:w-auto">
                        <a href="{{ route('closet.index') }}"
                           class="flex items-center gap-2 px-5 py-2.5 rounded-full font-bold text-sm transition-all whitespace-nowrap border shadow-sm
                           {{ !request('category') ? 'bg-slate-900 text-white border-slate-900' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">
                            Semua
                        </a>
                        @php
                            $categories = ['Casual', 'Streetwear', 'Formal', 'Sporty', 'Vintage', 'Minimalist'];
                        @endphp
                        @foreach($categories as $cat)
                            <a href="{{ route('closet.index', ['category' => $cat]) }}"
                               class="flex items-center gap-2 px-5 py-2.5 rounded-full font-bold text-sm transition-all whitespace-nowrap border shadow-sm
                               {{ request('category') === $cat ? 'bg-slate-900 text-white border-slate-900' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">
                                {{ $cat }}
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- ITEM GRID --}}
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                    @forelse($items ?? [] as $item)
                        <div class="group bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 flex flex-col overflow-hidden">
                            
                            {{-- Image Area --}}
                            <div class="relative aspect-[4/5] overflow-hidden bg-slate-100">
                                @if($item->image_url)
                                    <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-300">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                                
                                {{-- Category Badge --}}
                                <span class="absolute top-3 left-3 text-[10px] font-bold px-2.5 py-1 rounded border uppercase tracking-wider bg-white/95 backdrop-blur-sm text-slate-900 border-slate-200 shadow-sm">
                                    {{ $item->category }}
                                </span>
                                
                                {{-- Quick Add to Album Button --}}
                                @if(count($albums) > 0)
                                <div class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button @click.prevent="openAddToAlbumModal({{ $item->id }}, '{{ addslashes($item->name) }}')" 
                                            class="w-8 h-8 bg-white/95 backdrop-blur-sm rounded-full flex items-center justify-center shadow-sm hover:bg-white text-slate-600 hover:text-blue-600 transition-all" title="Tambah ke Album">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    </button>
                                </div>
                                @endif
                            </div>

                            {{-- Content Area --}}
                            <div class="p-4 flex-grow flex flex-col">
                                <h3 class="font-bold text-slate-900 text-sm leading-tight mb-1 line-clamp-1 group-hover:text-blue-600 transition-colors">{{ $item->name }}</h3>
                                <p class="text-xs text-slate-500 line-clamp-2 mb-4 flex-1">{{ $item->description }}</p>
                                
                                {{-- Action Buttons --}}
                                <div class="flex gap-2 pt-3 border-t border-slate-200">
                                    <button @click="openRenameModal({{ $item->id }}, '{{ addslashes($item->name) }}', '{{ addslashes($item->description) }}')" 
                                            class="flex-1 flex items-center justify-center py-2 text-slate-400 hover:text-blue-600 transition-colors text-sm" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>
                                    
                                    <form id="deleteForm{{ $item->id }}" action="{{ route('closet.destroy', $item) }}" method="POST" class="contents">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="showDeleteItemConfirm('{{ addslashes($item->name) }}', document.getElementById('deleteForm{{ $item->id }}'))" 
                                                class="flex-1 flex items-center justify-center py-2 text-slate-400 hover:text-red-600 transition-colors text-sm" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        {{-- Empty State --}}
                        <div class="col-span-full py-20 text-center">
                            <div class="max-w-md mx-auto">
                                <div class="w-24 h-24 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                    <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-slate-900 mb-2">Belum Ada Item Tanpa Album</h3>
                                <p class="text-slate-600 mb-8">
                                    Semua item mu sudah terorganisir dalam album.
                                </p>
                                <a href="{{ route('explore.index') }}" class="inline-flex items-center px-6 py-3 bg-slate-900 text-white rounded-full font-bold hover:bg-slate-800 transition-colors shadow-md">
                                    Tambah Item Baru
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                @if(isset($items) && $items->hasPages())
                    <div class="mt-12 pt-6 border-t border-slate-200">
                        {{ $items->links() }}
                    </div>
                @endif
            </div>
        </div>

        {{-- CREATE ALBUM MODAL --}}
        <div x-show="showNewAlbumModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" @keydown.escape="showNewAlbumModal = false">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="showNewAlbumModal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm" @click="showNewAlbumModal = false"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                <div x-show="showNewAlbumModal" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form action="{{ route('closet.album.create') }}" method="POST">
                        @csrf
                        <div class="bg-white px-6 pt-6 pb-6 border-b border-slate-200">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-lg font-bold text-slate-900">Buat Album Baru</h3>
                                <button type="button" @click="showNewAlbumModal = false" class="text-slate-400 hover:text-slate-600">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-bold text-slate-900 mb-2">Nama Album</label>
                                    <input type="text" name="name" placeholder="Contoh: Casual Weekend" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-slate-900 focus:ring-0 text-slate-900 transition-all" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-900 mb-2">Deskripsi (Opsional)</label>
                                    <textarea name="description" placeholder="Deskripsikan tema atau gaya album ini..." rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-slate-900 focus:ring-0 text-slate-900 transition-all"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="bg-slate-50 px-6 py-4 flex flex-row-reverse gap-3 border-t border-slate-200">
                            <button type="submit" class="inline-flex justify-center rounded-xl px-6 py-2.5 bg-slate-900 text-sm font-bold text-white hover:bg-slate-800 transition-all shadow-md">
                                Buat Album
                            </button>
                            <button type="button" @click="showNewAlbumModal = false" class="inline-flex justify-center rounded-xl px-6 py-2.5 bg-white border border-slate-200 text-sm font-bold text-slate-700 hover:bg-slate-50 transition-all">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- ADD TO ALBUM MODAL --}}
        <div x-show="addToAlbumModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" @keydown.escape="addToAlbumModal = false">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="addToAlbumModal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm" @click="addToAlbumModal = false"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                <div x-show="addToAlbumModal" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form @submit.prevent="submitAddToAlbum()">
                        <div class="bg-white px-6 pt-6 pb-6 border-b border-slate-200">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-lg font-bold text-slate-900">Tambah ke Album</h3>
                                <button type="button" @click="addToAlbumModal = false; $el.parentElement.parentElement.parentElement.parentElement.querySelector('input[name=album_id]:checked').checked = false;" class="text-slate-400 hover:text-slate-600">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </div>

                            <p class="text-slate-600 text-sm mb-4 font-medium" x-text="'Item: ' + selectedItemName"></p>

                            <div class="space-y-2">
                                @foreach($albums as $album)
                                <label class="flex items-center p-3 rounded-xl border-2 border-slate-200 hover:border-slate-300 hover:bg-slate-50 cursor-pointer transition-all">
                                    <input type="radio" name="album_id" value="{{ $album->id }}" class="w-4 h-4 text-slate-900" @change="console.log('Album selected: {{ $album->id }}')">
                                    <span class="ml-3 flex-1">
                                        <span class="block font-semibold text-slate-900">{{ $album->name }}</span>
                                        <span class="text-xs text-slate-500">{{ $album->items_count }} item</span>
                                    </span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        <div class="bg-slate-50 px-6 py-4 flex flex-row-reverse gap-3 border-t border-slate-200">
                            <button type="submit" class="inline-flex justify-center rounded-xl px-6 py-2.5 bg-slate-900 text-sm font-bold text-white hover:bg-slate-800 transition-all shadow-md">
                                Tambah
                            </button>
                            <button type="button" @click="addToAlbumModal = false" class="inline-flex justify-center rounded-xl px-6 py-2.5 bg-white border border-slate-200 text-sm font-bold text-slate-700 hover:bg-slate-50 transition-all">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- EDIT ITEM MODAL --}}
        <div x-show="renameModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" @keydown.escape="renameModal = false">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="renameModal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm" @click="renameModal = false"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                <div x-show="renameModal" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form method="POST" action="#" x-ref="renameForm">
                        @csrf
                        @method('PATCH')
                        <div class="bg-white px-6 pt-6 pb-6 border-b border-slate-200">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-lg font-bold text-slate-900">Edit Detail Item</h3>
                                <button type="button" @click="renameModal = false" class="text-slate-400 hover:text-slate-600">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-bold text-slate-900 mb-2">Nama Item</label>
                                    <input type="text" name="name" x-ref="renameName" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-slate-900 focus:ring-0 text-slate-900 transition-all" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-900 mb-2">Catatan (Opsional)</label>
                                    <textarea name="description" x-ref="renameDescription" rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-slate-900 focus:ring-0 text-slate-900 transition-all" placeholder="Tambahkan catatan tentang item ini..."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="bg-slate-50 px-6 py-4 flex flex-row-reverse gap-3 border-t border-slate-200">
                            <button type="submit" class="inline-flex justify-center rounded-xl px-6 py-2.5 bg-slate-900 text-sm font-bold text-white hover:bg-slate-800 transition-all shadow-md">
                                Simpan Perubahan
                            </button>
                            <button type="button" @click="renameModal = false" class="inline-flex justify-center rounded-xl px-6 py-2.5 bg-white border border-slate-200 text-sm font-bold text-slate-700 hover:bg-slate-50 transition-all">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function closetApp() {
            return {
                showNewAlbumModal: false,
                renameModal: false,
                addToAlbumModal: false,
                selectedItem: null,
                selectedItemName: '',
                notification: null,
                
                showNotification(message, type = 'success') {
                    this.notification = { message, type };
                    setTimeout(() => {
                        this.notification = null;
                    }, 3000);
                },
                
                openRenameModal(itemId, itemName, itemDesc) {
                    this.selectedItem = itemId;
                    this.renameModal = true;
                    this.$nextTick(() => {
                        this.$refs.renameName.value = itemName;
                        this.$refs.renameDescription.value = itemDesc || '';
                        this.$refs.renameForm.action = '/closet/' + itemId; 
                    });
                },
                
                openAddToAlbumModal(itemId, itemName) {
                    this.selectedItem = itemId;
                    this.selectedItemName = itemName;
                    this.addToAlbumModal = true;
                },
                
                submitAddToAlbum() {
                    console.log('🔄 submitAddToAlbum called');
                    console.log('selectedItem:', this.selectedItem);
                    console.log('selectedItemName:', this.selectedItemName);
                    
                    const albumId = document.querySelector('input[name="album_id"]:checked')?.value;
                    console.log('albumId:', albumId);
                    
                    if (!albumId) {
                        console.warn('❌ No album selected');
                        this.showNotification('Pilih album terlebih dahulu!', 'error');
                        return;
                    }

                    if (!this.selectedItem) {
                        console.warn('❌ No item selected');
                        this.showNotification('Item tidak ditemukan', 'error');
                        return;
                    }

                    console.log('📤 Sending request to /closet/item/add-to-album');
                    
                    const payload = {
                        item_id: this.selectedItem,
                        album_id: parseInt(albumId)
                    };
                    console.log('Payload:', payload);

                    fetch('/closet/item/add-to-album', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify(payload)
                    })
                    .then(res => {
                        console.log('Response status:', res.status);
                        if (!res.ok) {
                            if (res.status === 403) {
                                throw new Error('Tidak memiliki akses ke item atau album ini');
                            }
                            throw new Error('HTTP ' + res.status);
                        }
                        return res.json();
                    })
                    .then(data => {
                        console.log('✅ Success:', data);
                        this.showNotification('Item berhasil ditambahkan ke album! ✓', 'success');
                        this.addToAlbumModal = false;
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    })
                    .catch(err => {
                        console.error('❌ Error:', err.message);
                        this.showNotification('Gagal: ' + err.message, 'error');
                    });
                }
            };
        }
    </script>
    
    {{-- Toast Notification --}}
    <template x-if="notification">
        <div class="fixed bottom-6 right-6 z-[9999] animate-slide-in">
            <div :class="{
                'bg-green-500': notification.type === 'success',
                'bg-red-500': notification.type === 'error',
                'bg-blue-500': notification.type === 'info'
            }" class="text-white px-6 py-4 rounded-xl shadow-lg font-medium flex items-center gap-3">
                <svg x-show="notification.type === 'success'" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                <svg x-show="notification.type === 'error'" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                <span x-text="notification.message"></span>
            </div>
        </div>
    </template>
</x-layout>