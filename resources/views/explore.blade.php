<x-layout>
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>

    <div x-data="exploreFilters" class="min-h-screen bg-slate-50">
        
        <section class="relative overflow-hidden bg-white pb-12 pt-48 border-b border-slate-200">
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-50 rounded-full blur-3xl opacity-60 -mr-20 -mt-20 pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="space-y-4 text-center md:text-left">
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                        Explore <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">Fashion</span>
                    </h1>
                    <p class="text-base text-slate-600 max-w-2xl mx-auto md:mx-0">
                        Temukan inspirasi gaya terbaru, koleksi brand lokal, dan outfit yang cocok untukmu.
                    </p>
                </div>

                <div class="mt-8 flex flex-col md:flex-row gap-4 items-center justify-between">
                    
                    <form action="{{ route('explore.index') }}" method="GET" class="relative w-full md:max-w-md group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400 group-focus-within:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari atasan, hoodie, atau brand..."
                               class="block w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-full text-base text-slate-900 placeholder-slate-400 focus:border-slate-900 focus:ring-0 transition-all shadow-sm hover:border-slate-300">
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                    </form>

                    <button @click="openFilter = true" class="flex items-center gap-2 px-6 py-3 bg-white border border-slate-200 text-slate-700 rounded-full font-bold text-sm hover:bg-slate-900 hover:text-white hover:border-slate-900 transition-all shadow-sm whitespace-nowrap">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Filter & Sort
                    </button>
                </div>

                <div class="mt-6 flex gap-3 overflow-x-auto pb-2 no-scrollbar">
                    @foreach($categories as $cat)
                        <a href="{{ route('explore.index', ['category' => $cat === 'Semua' ? null : $cat, 'search' => request('search')]) }}"
                           class="flex items-center gap-2 px-5 py-2.5 rounded-full font-bold text-sm transition-all whitespace-nowrap border shadow-sm
                           {{ (request('category') == $cat || (request('category') == null && $cat == 'Semua'))
                               ? 'bg-slate-900 text-white border-slate-900' 
                               : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">
                           {{ $cat }}
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                @forelse($items as $item)
                    <div class="group bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 flex flex-col overflow-hidden relative">
                        
                        <button @click.prevent="toggleWishlist({{ $item->id }})"
                                class="absolute top-3 right-3 w-8 h-8 bg-white/95 backdrop-blur-sm rounded-full flex items-center justify-center shadow-sm hover:bg-white transition z-10">
                            <svg class="w-5 h-5 transition-colors duration-300" 
                                 :class="wishlistedItems.includes({{ $item->id }}) ? 'text-red-500 fill-current' : 'text-gray-400'" 
                                 viewBox="0 0 24 24" stroke="currentColor" fill="none">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </button>

                        <a href="{{ route('products.show', $item) }}" class="flex-grow flex flex-col">
                            <div class="relative aspect-[4/5] overflow-hidden bg-slate-100">
                                <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                
                                @if($item->original_price && $item->original_price > $item->price)
                                    <div class="absolute top-3 left-3 bg-red-500 text-white text-[10px] font-bold px-2.5 py-1 rounded-full shadow-sm">
                                        SALE
                                    </div>
                                @endif
                            </div>

                            <div class="p-4 flex flex-col flex-grow">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded border uppercase tracking-wider
                                        {{ $item->store_name == 'Tokopedia' ? 'text-green-600 border-green-200 bg-green-50' :
                                          ($item->store_name == 'Shopee' ? 'text-orange-600 border-orange-200 bg-orange-50' :
                                          'text-blue-600 border-blue-200 bg-blue-50') }}">
                                        {{ $item->store_name }}
                                    </span>
                                </div>

                                <h3 class="text-slate-900 font-bold text-sm leading-snug line-clamp-2 mb-1 group-hover:text-blue-600 transition">
                                    {{ $item->name }}
                                </h3>

                                <div class="mt-auto pt-3 border-t border-slate-100 flex items-end gap-2">
                                    <span class="text-slate-900 font-extrabold text-base">
                                        Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </span>
                                    @if($item->original_price && $item->original_price > $item->price)
                                        <span class="text-xs text-slate-400 line-through mb-0.5">
                                            Rp {{ number_format($item->original_price, 0, ',', '.') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center">
                        <div class="max-w-md mx-auto">
                            <div class="w-24 h-24 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900 mb-2">Tidak ada hasil ditemukan</h3>
                            <p class="text-slate-600 mb-8">
                                Coba gunakan kata kunci lain atau reset filter untuk melihat semua produk.
                            </p>
                            <a href="{{ route('explore.index') }}" class="inline-flex items-center px-6 py-3 bg-slate-900 text-white rounded-full font-bold hover:bg-slate-800 transition-colors shadow-md">
                                Reset Pencarian
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="mt-12">
                {{ $items->links() }}
            </div>
        </section>

        <div x-show="openFilter" x-cloak class="relative z-50" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
            <div x-show="openFilter" 
                 x-transition:enter="ease-in-out duration-500" 
                 x-transition:enter-start="opacity-0" 
                 x-transition:enter-end="opacity-100" 
                 x-transition:leave="ease-in-out duration-500" 
                 x-transition:leave-start="opacity-100" 
                 x-transition:leave-end="opacity-0" 
                 class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" 
                 @click="openFilter = false"></div>

            <div class="fixed inset-0 overflow-hidden">
                <div class="absolute inset-0 overflow-hidden">
                    <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                        <div x-show="openFilter"
                             x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                             x-transition:enter-start="translate-x-full"
                             x-transition:enter-end="translate-x-0"
                             x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                             x-transition:leave-start="translate-x-0"
                             x-transition:leave-end="translate-x-full"
                             class="pointer-events-auto w-screen max-w-md">
                            
                            <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-2xl">
                                <div class="px-4 py-6 sm:px-6 border-b border-slate-200 flex items-center justify-between">
                                    <h2 class="text-lg font-bold text-slate-900" id="slide-over-title">Filter & Urutkan</h2>
                                    <button @click="openFilter = false" class="rounded-md text-slate-400 hover:text-slate-500 focus:outline-none">
                                        <span class="sr-only">Close panel</span>
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>

                                <div class="relative mt-6 flex-1 px-4 sm:px-6 space-y-8">
                                    <div>
                                        <h3 class="text-sm font-bold text-slate-900 mb-3">Rentang Harga</h3>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-xs font-medium text-slate-600 mb-1">Minimum</label>
                                                <div class="relative">
                                                    <span class="absolute left-3 top-2 text-slate-400 text-sm">Rp</span>
                                                    <input type="number" x-model="minPrice" class="w-full pl-9 px-3 py-2 border border-slate-200 rounded-lg text-sm focus:border-slate-900 focus:ring-0">
                                                </div>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-slate-600 mb-1">Maksimum</label>
                                                <div class="relative">
                                                    <span class="absolute left-3 top-2 text-slate-400 text-sm">Rp</span>
                                                    <input type="number" x-model="maxPrice" class="w-full pl-9 px-3 py-2 border border-slate-200 rounded-lg text-sm focus:border-slate-900 focus:ring-0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <h3 class="text-sm font-bold text-slate-900 mb-3">Urutkan</h3>
                                        <div class="space-y-3">
                                            <label class="flex items-center group cursor-pointer">
                                                <input type="radio" x-model="sortBy" value="latest" class="text-slate-900 focus:ring-slate-900 border-slate-300">
                                                <span class="ml-3 text-sm text-slate-600 group-hover:text-slate-900">Terbaru</span>
                                            </label>
                                            <label class="flex items-center group cursor-pointer">
                                                <input type="radio" x-model="sortBy" value="price_low" class="text-slate-900 focus:ring-slate-900 border-slate-300">
                                                <span class="ml-3 text-sm text-slate-600 group-hover:text-slate-900">Harga Terendah</span>
                                            </label>
                                            <label class="flex items-center group cursor-pointer">
                                                <input type="radio" x-model="sortBy" value="price_high" class="text-slate-900 focus:ring-slate-900 border-slate-300">
                                                <span class="ml-3 text-sm text-slate-600 group-hover:text-slate-900">Harga Tertinggi</span>
                                            </label>
                                            <label class="flex items-center group cursor-pointer">
                                                <input type="radio" x-model="sortBy" value="rating" class="text-slate-900 focus:ring-slate-900 border-slate-300">
                                                <span class="ml-3 text-sm text-slate-600 group-hover:text-slate-900">Rating Tertinggi</span>
                                            </label>
                                        </div>
                                    </div>
                                    

                                </div>

                                <div class="border-t border-slate-200 p-6 flex gap-3">
                                    <button @click="resetFilters()" class="flex-1 px-4 py-3 text-sm font-bold text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition">
                                        Reset
                                    </button>
                                    <button @click="applyFilters()" class="flex-1 px-4 py-3 text-sm font-bold text-white bg-slate-900 rounded-xl hover:bg-slate-800 transition shadow-md">
                                        Terapkan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('exploreFilters', () => ({
                openFilter: false,
                wishlistedItems: [],
                minPrice: '',
                maxPrice: '',
                sortBy: 'latest',

                init() {
                    this.loadFilters();
                    // Load Wishlist from LocalStorage immediately
                    const saved = localStorage.getItem('scanfit_wishlist');
                    if (saved) this.wishlistedItems = JSON.parse(saved);
                },

                toggleWishlist(itemId) {
                    const index = this.wishlistedItems.indexOf(itemId);
                    if (index > -1) {
                        this.wishlistedItems.splice(index, 1);
                    } else {
                        this.wishlistedItems.push(itemId);
                    }
                    localStorage.setItem('scanfit_wishlist', JSON.stringify(this.wishlistedItems));
                },

                loadFilters() {
                    const urlParams = new URLSearchParams(window.location.search);
                    this.minPrice = urlParams.get('min_price') || '';
                    this.maxPrice = urlParams.get('max_price') || '';
                    this.sortBy = urlParams.get('sort') || 'latest';
                },

                applyFilters() {
                    const params = new URLSearchParams(window.location.search);
                    if (this.minPrice) params.set('min_price', this.minPrice); else params.delete('min_price');
                    if (this.maxPrice) params.set('max_price', this.maxPrice); else params.delete('max_price');
                    params.set('sort', this.sortBy);
                    window.location.href = `${window.location.pathname}?${params.toString()}`;
                },

                resetFilters() {
                    this.minPrice = '';
                    this.maxPrice = '';
                    this.sortBy = 'latest';
                    window.location.href = window.location.pathname;
                }
            }));
        });
    </script>
</x-layout>