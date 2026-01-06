<x-layout>
    <x-slot:title>Admin Dashboard</x-slot:title>

    <div class="min-h-screen bg-slate-50">
        <section class="relative overflow-hidden bg-white pb-12 pt-48 border-b border-slate-200">
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-50 rounded-full blur-3xl opacity-60 -mr-20 -mt-20 pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="space-y-4 text-center md:text-left">
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                        Admin <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">Dashboard</span>
                    </h1>
                    <p class="text-base text-slate-600 max-w-2xl mx-auto md:mx-0">
                        Kelola pengguna, brand partner, dan sistem aplikasi Scanfit.
                    </p>
                </div>
            </div>
        </section>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            
            {{-- STATS GRID --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-600 mb-1">Total Pengguna</p>
                            <p class="text-3xl font-bold text-slate-900">{{ $stats['total_users'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM16 16a5 5 0 01-10 0"></path>
                            </svg>
                        </div>
                    </div>
                    <a href="{{ route('admin.users') }}" class="text-blue-600 text-sm font-semibold hover:underline mt-4 inline-block">Lihat Detail →</a>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-600 mb-1">Pengguna Premium</p>
                            <p class="text-3xl font-bold text-purple-600">{{ $stats['premium_users'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-slate-500 mt-4">{{ round(($stats['premium_users'] / max($stats['total_users'], 1)) * 100) }}% dari total</p>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-600 mb-1">Total Brand</p>
                            <p class="text-3xl font-bold text-emerald-600">{{ $stats['total_brands'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                    </div>
                    <a href="{{ route('admin.brands') }}" class="text-emerald-600 text-sm font-semibold hover:underline mt-4 inline-block">Lihat Detail →</a>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-600 mb-1">Pending Approval</p>
                            <p class="text-3xl font-bold text-orange-600">{{ $stats['pending_brands'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <a href="{{ route('admin.brands', ['status' => 'pending']) }}" class="text-orange-600 text-sm font-semibold hover:underline mt-4 inline-block">Review Sekarang →</a>
                </div>
            </div>

            {{-- NAVIGATION TABS --}}
            <div class="flex gap-3 mb-8 border-b border-slate-200 overflow-x-auto">
                <a href="{{ route('admin.dashboard') }}" class="px-6 py-4 border-b-2 font-bold text-slate-900 border-slate-900 whitespace-nowrap">Overview</a>
                <a href="{{ route('admin.brands') }}" class="px-6 py-4 border-b-2 font-bold text-slate-600 border-transparent hover:text-slate-900 hover:border-slate-300 transition whitespace-nowrap">Brands</a>
                <a href="{{ route('admin.users') }}" class="px-6 py-4 border-b-2 font-bold text-slate-600 border-transparent hover:text-slate-900 hover:border-slate-300 transition whitespace-nowrap">Pengguna</a>
                <a href="{{ route('admin.banners.index') }}" class="px-6 py-4 border-b-2 font-bold text-slate-600 border-transparent hover:text-slate-900 hover:border-slate-300 transition whitespace-nowrap">Banners</a>
                <a href="{{ route('admin.settings') }}" class="px-6 py-4 border-b-2 font-bold text-slate-600 border-transparent hover:text-slate-900 hover:border-slate-300 transition whitespace-nowrap">Pengaturan</a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- RECENT USERS --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-200">
                            <h3 class="text-lg font-bold text-slate-900">Pengguna Terbaru</h3>
                        </div>
                        <div class="divide-y divide-slate-200">
                            @forelse($recentUsers as $user)
                            <div class="px-6 py-4 hover:bg-slate-50 transition">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                            <span class="text-sm font-bold text-blue-600">{{ substr($user->name, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-slate-900">{{ $user->name }}</p>
                                            <p class="text-xs text-slate-500">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        @if($user->is_premium)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-purple-100 text-purple-700">Premium</span>
                                        @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-700">Free</span>
                                        @endif
                                        <p class="text-xs text-slate-500 mt-1">{{ $user->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="px-6 py-12 text-center text-slate-500">
                                Belum ada pengguna
                            </div>
                            @endforelse
                        </div>
                        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
                            <a href="{{ route('admin.users') }}" class="text-blue-600 text-sm font-semibold hover:underline">Lihat Semua Pengguna →</a>
                        </div>
                    </div>
                </div>

                {{-- BRAND STATS --}}
                <div>
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                        <h3 class="text-lg font-bold text-slate-900 mb-6">Status Brand</h3>
                        <div class="space-y-4">
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-medium text-slate-600">Approved</span>
                                    <span class="text-lg font-bold text-emerald-600">{{ $stats['approved_brands'] }}</span>
                                </div>
                                <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-emerald-500" style="width: {{ ($stats['approved_brands'] / max($stats['total_brands'], 1)) * 100 }}%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-medium text-slate-600">Pending</span>
                                    <span class="text-lg font-bold text-orange-600">{{ $stats['pending_brands'] }}</span>
                                </div>
                                <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-orange-500" style="width: {{ ($stats['pending_brands'] / max($stats['total_brands'], 1)) * 100 }}%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-medium text-slate-600">Rejected</span>
                                    <span class="text-lg font-bold text-red-600">{{ $stats['rejected_brands'] }}</span>
                                </div>
                                <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-red-500" style="width: {{ ($stats['rejected_brands'] / max($stats['total_brands'], 1)) * 100 }}%"></div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('admin.brands') }}" class="block w-full mt-6 px-4 py-2 bg-slate-900 text-white font-semibold rounded-xl hover:bg-slate-800 transition text-center">
                            Kelola Brand
                        </a>
                    </div>

                    {{-- BANNER MANAGEMENT SECTION --}}
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm mt-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-slate-900">Manajemen Banner Iklan</h3>
                            <a href="{{ route('admin.banners.index') }}" class="text-blue-600 text-sm font-semibold hover:underline">
                                Lihat Semua →
                            </a>
                        </div>

                        {{-- Banner Stats --}}
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6 pb-6 border-b border-slate-200">
                            <div class="bg-slate-50 rounded-lg p-3">
                                <p class="text-slate-600 text-xs font-medium">Total Banner</p>
                                <p class="text-xl font-bold text-slate-900 mt-1">{{ $bannerStats['total'] ?? 0 }}</p>
                            </div>
                            <div class="bg-blue-50 rounded-lg p-3">
                                <p class="text-slate-600 text-xs font-medium">Aktif</p>
                                <p class="text-xl font-bold text-blue-600 mt-1">{{ $bannerStats['active'] ?? 0 }}</p>
                            </div>
                            <div class="bg-yellow-50 rounded-lg p-3">
                                <p class="text-slate-600 text-xs font-medium">Menunggu Review</p>
                                <p class="text-xl font-bold text-yellow-600 mt-1">{{ $bannerStats['pending'] ?? 0 }}</p>
                            </div>
                            <div class="bg-red-50 rounded-lg p-3">
                                <p class="text-slate-600 text-xs font-medium">Ditolak</p>
                                <p class="text-xl font-bold text-red-600 mt-1">{{ $bannerStats['rejected'] ?? 0 }}</p>
                            </div>
                        </div>

                        {{-- Pending Banners for Review --}}
                        @if($pendingBanners && $pendingBanners->count() > 0)
                            <div class="space-y-3">
                                <h4 class="text-sm font-semibold text-slate-900">Pending Review</h4>
                                @foreach($pendingBanners as $banner)
                                    <div class="border border-yellow-200 bg-yellow-50 rounded-lg p-4 flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            @if($banner->banner_image_url)
                                                <img src="{{ asset('storage/' . $banner->banner_image_url) }}" 
                                                     alt="{{ $banner->title }}"
                                                     class="w-12 h-12 rounded object-cover">
                                            @else
                                                <div class="w-12 h-12 rounded bg-slate-200"></div>
                                            @endif
                                            <div>
                                                <p class="font-semibold text-slate-900">{{ $banner->title }}</p>
                                                <p class="text-xs text-slate-600">{{ $banner->brand->name ?? 'Unknown' }}</p>
                                            </div>
                                        </div>
                                        <a href="{{ route('admin.banners.show', $banner) }}" 
                                           class="px-3 py-1.5 bg-blue-600 text-white text-xs font-semibold rounded hover:bg-blue-700 transition">
                                            Review
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-slate-600 text-center py-4">Tidak ada banner menunggu review</p>
                        @endif
                    </div>

                    {{-- QUICK ACTIONS --}}
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm mt-6">
                        <h3 class="text-lg font-bold text-slate-900 mb-4">Aksi Cepat</h3>
                        <div class="space-y-2">
                            <a href="{{ route('admin.brands', ['status' => 'pending']) }}" class="block px-4 py-2.5 bg-slate-50 hover:bg-slate-100 text-slate-900 font-semibold rounded-xl transition border border-slate-200">
                                📋 Review Brand Pending
                            </a>
                            <a href="{{ route('admin.users') }}" class="block px-4 py-2.5 bg-slate-50 hover:bg-slate-100 text-slate-900 font-semibold rounded-xl transition border border-slate-200">
                                👥 Kelola Pengguna
                            </a>
                            <a href="{{ route('admin.settings') }}" class="block px-4 py-2.5 bg-slate-50 hover:bg-slate-100 text-slate-900 font-semibold rounded-xl transition border border-slate-200">
                                ⚙️ Pengaturan Sistem
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
