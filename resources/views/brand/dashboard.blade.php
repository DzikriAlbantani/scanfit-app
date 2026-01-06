<x-brand-layout>
    <x-slot:title>Brand Dashboard - ScanFit</x-slot:title>

    {{-- Real Data from Controller --}}
    @php
        $stats = [
            'total_products' => $totalProducts ?? 0,
            'total_scan_matches' => $totalScanMatches ?? 0,
            'total_clicks' => $totalClicks ?? 0,
            'total_wishlisted' => $totalWishlisted ?? 0,
            'conversion_rate' => $conversionRate ?? 0,
            'popular_products' => $popularProducts ?? collect(),
        ];
    @endphp

    <div class="space-y-8">
        {{-- Welcome Section --}}
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-2xl sm:rounded-3xl p-4 sm:p-6 md:p-8 text-white">
            <h1 class="text-2xl sm:text-3xl font-bold mb-2">Welcome back, {{ Auth::user()->name }}!</h1>
            <p class="text-sm sm:text-base text-blue-100">Here's what's happening with your brand on ScanFit today.</p>
        </div>

                {{-- Stats Cards --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                    {{-- Total Scan Matches --}}
                    <div class="bg-white rounded-2xl p-4 sm:p-6 shadow-sm border border-slate-200 relative overflow-hidden">
                        <div class="absolute top-3 sm:top-4 right-3 sm:right-4 w-10 sm:w-12 h-10 sm:h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 sm:w-6 h-5 sm:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div class="pr-12 sm:pr-16">
                            <p class="text-xs sm:text-sm font-medium text-slate-600 mb-1">Total Scan Matches</p>
                            <p class="text-2xl sm:text-3xl font-bold text-slate-900">{{ number_format($stats['total_scan_matches']) }}</p>
                            <p class="text-xs text-slate-500 font-medium mt-1">Produk muncul di hasil scan</p>
                        </div>
                    </div>

                    {{-- Product Views --}}
                    <div class="bg-white rounded-2xl p-4 sm:p-6 shadow-sm border border-slate-200 relative overflow-hidden">
                        <div class="absolute top-3 sm:top-4 right-3 sm:right-4 w-10 sm:w-12 h-10 sm:h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 sm:w-6 h-5 sm:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                        <div class="pr-12 sm:pr-16">
                            <p class="text-xs sm:text-sm font-medium text-slate-600 mb-1">Product Views</p>
                            <p class="text-2xl sm:text-3xl font-bold text-slate-900">{{ number_format($stats['total_clicks']) }}</p>
                            <p class="text-xs text-slate-500 font-medium mt-1">Total klik produk</p>
                        </div>
                    </div>

                    {{-- Wishlisted --}}
                    <div class="bg-white rounded-2xl p-4 sm:p-6 shadow-sm border border-slate-200 relative overflow-hidden">
                        <div class="absolute top-3 sm:top-4 right-3 sm:right-4 w-10 sm:w-12 h-10 sm:h-12 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 sm:w-6 h-5 sm:h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                        <div class="pr-12 sm:pr-16">
                            <p class="text-xs sm:text-sm font-medium text-slate-600 mb-1">Wishlisted</p>
                            <p class="text-2xl sm:text-3xl font-bold text-slate-900">{{ number_format($stats['total_wishlisted']) }}</p>
                            <p class="text-xs text-slate-500 font-medium mt-1">Disimpan ke closet</p>
                        </div>
                    </div>

                    {{-- Conversion Rate --}}
                    <div class="bg-white rounded-2xl p-4 sm:p-6 shadow-sm border border-slate-200 relative overflow-hidden">
                        <div class="absolute top-3 sm:top-4 right-3 sm:right-4 w-10 sm:w-12 h-10 sm:h-12 bg-purple-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 sm:w-6 h-5 sm:h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <div class="pr-12 sm:pr-16">
                            <p class="text-xs sm:text-sm font-medium text-slate-600 mb-1">Conversion Rate</p>
                            <p class="text-2xl sm:text-3xl font-bold text-slate-900">{{ number_format($stats['conversion_rate'], 1) }}%</p>
                            <p class="text-xs text-slate-500 font-medium mt-1">Saved / Views ratio</p>
                        </div>
                    </div>
                </div>

                {{-- Analytics Chart Section --}}
                <div class="bg-white rounded-2xl sm:rounded-3xl p-4 sm:p-6 md:p-8 shadow-sm border border-slate-200">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
                        <h2 class="text-xl sm:text-2xl font-bold text-slate-900">Performa 30 Hari Terakhir</h2>
                        <select id="chartType" class="px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full sm:w-auto">
                            <option value="clicks">Product Views</option>
                            <option value="scans">Scan Matches</option>
                            <option value="saves">Saves to Closet</option>
                        </select>
                    </div>

                    {{-- Real Chart Canvas --}}
                    <div class="relative overflow-x-auto" style="height: 300px;">
                        <canvas id="performanceChart"></canvas>
                    </div>
                </div>

                {{-- Products Table --}}
                <div class="bg-white rounded-2xl sm:rounded-3xl p-4 sm:p-6 md:p-8 shadow-sm border border-slate-200">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
                        <div>
                            <h2 class="text-xl sm:text-2xl font-bold text-slate-900">Produk</h2>
                            <p class="text-slate-600 text-xs sm:text-sm mt-1">Kelola dan pantau performa produk Anda</p>
                        </div>
                        <a href="{{ route('brand.products.create') }}" class="inline-flex items-center justify-center sm:justify-start px-4 sm:px-6 py-2.5 sm:py-3 bg-blue-600 text-white rounded-xl font-medium hover:bg-blue-700 transition-colors shadow-sm whitespace-nowrap text-sm sm:text-base">
                            <svg class="w-4 sm:w-5 h-4 sm:h-5 sm:mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span class="hidden sm:inline">Tambah Produk</span>
                            <span class="sm:hidden">Tambah</span>
                        </a>
                    </div>

                    @if($popularProducts->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full min-w-[800px]">
                                <thead>
                                    <tr class="border-b-2 border-slate-200 bg-slate-50">
                                        <th class="text-left py-4 px-4 font-bold text-slate-700 text-xs uppercase tracking-wider">Produk</th>
                                        <th class="text-left py-4 px-4 font-bold text-slate-700 text-xs uppercase tracking-wider">Kategori</th>
                                        <th class="text-left py-4 px-4 font-bold text-slate-700 text-xs uppercase tracking-wider">Harga</th>
                                        <th class="text-center py-4 px-4 font-bold text-slate-700 text-xs uppercase tracking-wider">Views</th>
                                        <th class="text-center py-4 px-4 font-bold text-slate-700 text-xs uppercase tracking-wider">Saves</th>
                                        <th class="text-center py-4 px-4 font-bold text-slate-700 text-xs uppercase tracking-wider">Stok</th>
                                        <th class="text-center py-4 px-4 font-bold text-slate-700 text-xs uppercase tracking-wider">Status</th>
                                        <th class="text-center py-4 px-4 font-bold text-slate-700 text-xs uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach($popularProducts as $product)
                                        <tr class="hover:bg-slate-50 transition-colors group">
                                            <td class="py-4 px-4">
                                                <div class="flex items-center space-x-4">
                                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-14 h-14 rounded-xl object-cover ring-2 ring-slate-100 group-hover:ring-blue-200 transition-all">
                                                    <div>
                                                        <p class="font-semibold text-slate-900 group-hover:text-blue-600 transition-colors">{{ Str::limit($product->name, 40) }}</p>
                                                        <p class="text-xs text-slate-500 mt-0.5">{{ $product->created_at->format('d M Y') }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4 px-4">
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-100 text-slate-700">
                                                    {{ $product->category }}
                                                </span>
                                            </td>
                                            <td class="py-4 px-4">
                                                <div>
                                                    <p class="font-bold text-slate-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                                    @if($product->original_price && $product->original_price > $product->price)
                                                        <p class="text-xs text-slate-400 line-through">Rp {{ number_format($product->original_price, 0, ',', '.') }}</p>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="py-4 px-4 text-center">
                                                <div class="flex items-center justify-center space-x-1">
                                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                    <span class="font-semibold text-slate-700">{{ number_format($product->clicks_count ?? 0) }}</span>
                                                </div>
                                            </td>
                                            <td class="py-4 px-4 text-center">
                                                <div class="flex items-center justify-center space-x-1">
                                                    <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                                    </svg>
                                                    <span class="font-semibold text-slate-700">{{ number_format($product->saves_count ?? 0) }}</span>
                                                </div>
                                            </td>
                                            <td class="py-4 px-4 text-center">
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold
                                                    {{ ($product->stock ?? 0) > 10 ? 'bg-green-100 text-green-700' : (($product->stock ?? 0) > 0 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                                    {{ $product->stock ?? 0 }}
                                                </span>
                                            </td>
                                            <td class="py-4 px-4 text-center">
                                                <button onclick="toggleStatus({{ $product->id }}, '{{ $product->status ?? 'active' }}')"
                                                        class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold transition-all cursor-pointer
                                                        {{ ($product->status ?? 'active') === 'active' ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                                                    <span class="w-2 h-2 rounded-full mr-1.5 {{ ($product->status ?? 'active') === 'active' ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                                                    {{ ucfirst($product->status ?? 'active') }}
                                                </button>
                                            </td>
                                            <td class="py-4 px-4">
                                                <div class="flex items-center justify-center space-x-2">
                                                    <a href="{{ route('products.show', $product) }}" target="_blank"
                                                       class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Lihat">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                        </svg>
                                                    </a>
                                                    <a href="{{ route('brand.products.edit', $product) }}"
                                                       class="p-2 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors" title="Edit">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                    </a>
                                                    <button onclick="deleteProduct({{ $product->id }}, '{{ $product->name }}')"
                                                            class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6 pt-6 border-t border-slate-200 flex justify-between items-center">
                            <p class="text-sm text-slate-600">Menampilkan {{ $popularProducts->count() }} produk teratas</p>
                            <a href="{{ route('brand.products.index') }}" class="text-blue-600 hover:text-blue-700 font-semibold text-sm flex items-center space-x-1">
                                <span>Lihat Semua Produk</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <h3 class="text-lg font-semibold text-slate-700 mb-2">Belum Ada Produk</h3>
                            <p class="text-slate-500 mb-6">Mulai tambahkan produk pertama Anda</p>
                            <a href="{{ route('brand.products.create') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-xl font-medium hover:bg-blue-700 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Tambah Produk Pertama
                            </a>
                        </div>
                    @endif
                </div>

                {{-- BANNERS SECTION --}}
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-200">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-slate-900">Manajemen Banner Iklan</h2>
                            <p class="text-slate-600 text-sm mt-1">Kelola banner promosi brand Anda</p>
                        </div>
                        <a href="{{ route('brand.banners.create') }}"
                           class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-xl font-medium hover:bg-blue-700 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Buat Banner Baru
                        </a>
                    </div>

                    {{-- Banner Stats --}}
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8 pb-8 border-b border-slate-200">
                        <div class="bg-slate-50 rounded-xl p-4">
                            <p class="text-slate-600 text-sm font-medium">Total Banner</p>
                            <p class="text-2xl font-bold text-slate-900 mt-1">{{ $bannerStats['total'] ?? 0 }}</p>
                        </div>
                        <div class="bg-blue-50 rounded-xl p-4">
                            <p class="text-slate-600 text-sm font-medium">Aktif</p>
                            <p class="text-2xl font-bold text-blue-600 mt-1">{{ $bannerStats['active'] ?? 0 }}</p>
                        </div>
                        <div class="bg-yellow-50 rounded-xl p-4">
                            <p class="text-slate-600 text-sm font-medium">Menunggu Approval</p>
                            <p class="text-2xl font-bold text-yellow-600 mt-1">{{ $bannerStats['pending'] ?? 0 }}</p>
                        </div>
                        <div class="bg-purple-50 rounded-xl p-4">
                            <p class="text-slate-600 text-sm font-medium">Total Klik</p>
                            <p class="text-2xl font-bold text-purple-600 mt-1">{{ number_format($bannerStats['clicks'] ?? 0) }}</p>
                        </div>
                    </div>

                    {{-- Banners List --}}
                    @if($banners && $banners->count() > 0)
                        <div class="space-y-4">
                            @foreach($banners as $banner)
                                <div class="border border-slate-200 rounded-2xl p-6 hover:shadow-md transition-shadow">
                                    <div class="flex gap-6">
                                        {{-- Banner Image Preview --}}
                                        <div class="w-32 h-32 bg-slate-100 rounded-xl overflow-hidden flex-shrink-0">
                                            @if($banner->banner_image_url)
                                                <img src="{{ asset('storage/' . $banner->banner_image_url) }}" 
                                                     alt="{{ $banner->title }}" 
                                                     class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-slate-400">
                                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>

                                        {{-- Banner Info --}}
                                        <div class="flex-1">
                                            <div class="flex items-start justify-between mb-3">
                                                <div>
                                                    <h3 class="text-lg font-bold text-slate-900">{{ $banner->title }}</h3>
                                                    <p class="text-slate-600 text-sm mt-1">{{ Str::limit($banner->description, 80) }}</p>
                                                </div>
                                                <span class="px-3 py-1 rounded-full text-sm font-semibold
                                                    @if($banner->status === 'active') bg-emerald-100 text-emerald-700
                                                    @elseif($banner->status === 'pending') bg-yellow-100 text-yellow-700
                                                    @elseif($banner->status === 'rejected') bg-red-100 text-red-700
                                                    @else bg-slate-100 text-slate-700
                                                    @endif">
                                                    {{ ucfirst($banner->status) }}
                                                </span>
                                            </div>

                                            {{-- Banner Stats --}}
                                            <div class="grid grid-cols-3 gap-4 mb-4 py-4 border-y border-slate-200">
                                                <div>
                                                    <p class="text-slate-600 text-xs font-medium">Klik</p>
                                                    <p class="text-lg font-bold text-slate-900">{{ number_format($banner->clicks ?? 0) }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-slate-600 text-xs font-medium">Impressions</p>
                                                    <p class="text-lg font-bold text-slate-900">{{ number_format($banner->impressions ?? 0) }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-slate-600 text-xs font-medium">CTR</p>
                                                    <p class="text-lg font-bold text-slate-900">
                                                        {{ $banner->impressions > 0 ? number_format(($banner->clicks / $banner->impressions) * 100, 2) : 0 }}%
                                                    </p>
                                                </div>
                                            </div>

                                            {{-- Actions --}}
                                            <div class="flex gap-2">
                                                <a href="{{ route('brand.banners.edit', $banner->id) }}"
                                                   class="px-4 py-2 text-blue-600 border border-blue-200 rounded-lg hover:bg-blue-50 transition-colors text-sm font-medium">
                                                    Edit
                                                </a>
                                                <button onclick="deleteBanner({{ $banner->id }}, '{{ $banner->title }}')"
                                                        class="px-4 py-2 text-red-600 border border-red-200 rounded-lg hover:bg-red-50 transition-colors text-sm font-medium">
                                                    Hapus
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Pagination --}}
                        @if($banners->hasPages())
                            <div class="mt-6 pt-6 border-t border-slate-200">
                                {{ $banners->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <h3 class="text-lg font-semibold text-slate-700 mb-2">Belum Ada Banner</h3>
                            <p class="text-slate-500 mb-6">Buat banner pertama Anda untuk mempromosikan brand</p>
                            <a href="{{ route('brand.banners.create') }}"
                               class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-xl font-medium hover:bg-blue-700 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Buat Banner Pertama
                            </a>
                        </div>
                    @endif
                </div>
            </main>
    </div>

    {{-- Chart.js Library --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    <script>
        // Chart Data from Laravel
        const chartData = @json($chartData);
        
        // Chart Configuration
        const ctx = document.getElementById('performanceChart').getContext('2d');
        let chart;
        
        const datasets = {
            clicks: {
                label: 'Product Views',
                data: chartData.clicks,
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                fill: true,
                tension: 0.4
            },
            scans: {
                label: 'Scan Matches',
                data: chartData.scans,
                borderColor: 'rgb(16, 185, 129)',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                fill: true,
                tension: 0.4
            },
            saves: {
                label: 'Saves to Closet',
                data: chartData.saves,
                borderColor: 'rgb(239, 68, 68)',
                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                fill: true,
                tension: 0.4
            }
        };
        
        function initChart(type = 'clicks') {
            if (chart) {
                chart.destroy();
            }
            
            chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartData.labels,
                    datasets: [datasets[type]]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            align: 'end',
                            labels: {
                                usePointStyle: true,
                                padding: 15,
                                font: {
                                    size: 12,
                                    weight: '600'
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            padding: 12,
                            titleFont: {
                                size: 13,
                                weight: 'bold'
                            },
                            bodyFont: {
                                size: 12
                            },
                            displayColors: true,
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + context.parsed.y;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 11
                                },
                                maxRotation: 0,
                                autoSkip: true,
                                maxTicksLimit: 15
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                font: {
                                    size: 11
                                },
                                callback: function(value) {
                                    return Math.round(value);
                                }
                            }
                        }
                    }
                }
            });
        }
        
        // Initialize chart on page load
        initChart('clicks');
        
        // Handle chart type change
        document.getElementById('chartType').addEventListener('change', function(e) {
            initChart(e.target.value);
        });

        // Toggle product status
        function toggleStatus(productId, currentStatus) {
            if (confirm('Apakah Anda yakin ingin mengubah status produk ini?')) {
                fetch(`/brand/products/${productId}/toggle-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Gagal mengubah status produk');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengubah status');
                });
            }
        }

        // Delete product
        function deleteProduct(productId, productName) {
            if (confirm(`Apakah Anda yakin ingin menghapus produk "${productName}"?\n\nTindakan ini tidak dapat dibatalkan.`)) {
                fetch(`/brand/products/${productId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Gagal menghapus produk');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menghapus produk');
                });
            }
        }

        // =========================================================================
        // BANNER MANAGEMENT FUNCTIONS
        // =========================================================================

        // Delete Banner
        function deleteBanner(bannerId, bannerTitle) {
            if (confirm(`Apakah Anda yakin ingin menghapus banner "${bannerTitle}"?\n\nTindakan ini tidak dapat dibatalkan.`)) {
                fetch(`/brand/banner/${bannerId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Gagal menghapus banner');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menghapus banner');
                });
            }
        }
    </script>
</x-brand-layout>