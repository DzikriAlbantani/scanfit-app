<x-layout>
    <x-slot:title>Manajemen Banner - Brand Dashboard</x-slot:title>

    <div class="min-h-screen bg-slate-50">
        <!-- Header -->
        <section class="relative overflow-hidden bg-white pb-12 pt-48 border-b border-slate-200">
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-50 rounded-full blur-3xl opacity-60 -mr-20 -mt-20 pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="space-y-4 text-center md:text-left">
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                        Manajemen <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-emerald-600">Banner Iklan</span>
                    </h1>
                    <p class="text-base text-slate-600 max-w-2xl">
                        Kelola kampanye iklan, promo, dan diskon untuk meningkatkan visibility brand Anda.
                    </p>
                </div>

                <div class="mt-8">
                    <a href="{{ route('brand.banners.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-slate-900 text-white rounded-full font-bold text-sm hover:bg-slate-800 transition shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Buat Banner Baru
                    </a>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                    <p class="text-sm text-slate-600 font-bold uppercase mb-2">Total Banner</p>
                    <p class="text-3xl font-bold text-slate-900">{{ $stats['total_banners'] }}</p>
                </div>
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                    <p class="text-sm text-slate-600 font-bold uppercase mb-2">Active</p>
                    <p class="text-3xl font-bold text-emerald-600">{{ $stats['active_banners'] }}</p>
                </div>
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                    <p class="text-sm text-slate-600 font-bold uppercase mb-2">Pending</p>
                    <p class="text-3xl font-bold text-orange-600">{{ $stats['pending_banners'] }}</p>
                </div>
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                    <p class="text-sm text-slate-600 font-bold uppercase mb-2">Total Clicks</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $stats['total_clicks'] }}</p>
                </div>
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                    <p class="text-sm text-slate-600 font-bold uppercase mb-2">Impressions</p>
                    <p class="text-3xl font-bold text-purple-600">{{ $stats['total_impressions'] }}</p>
                </div>
            </div>

            <!-- Filter -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm mb-6">
                <form action="{{ route('brand.banners.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-center">
                    <div class="flex gap-2 flex-wrap">
                        <a href="{{ route('brand.banners.index') }}" class="px-4 py-2 rounded-full font-bold text-sm transition {{ !request('status') ? 'bg-slate-900 text-white' : 'bg-slate-50 text-slate-700 border border-slate-200 hover:bg-slate-100' }}">
                            Semua
                        </a>
                        <a href="{{ route('brand.banners.index', ['status' => 'active']) }}" class="px-4 py-2 rounded-full font-bold text-sm transition {{ request('status') === 'active' ? 'bg-emerald-600 text-white' : 'bg-slate-50 text-slate-700 border border-slate-200 hover:bg-slate-100' }}">
                            Active
                        </a>
                        <a href="{{ route('brand.banners.index', ['status' => 'pending']) }}" class="px-4 py-2 rounded-full font-bold text-sm transition {{ request('status') === 'pending' ? 'bg-orange-600 text-white' : 'bg-slate-50 text-slate-700 border border-slate-200 hover:bg-slate-100' }}">
                            Pending
                        </a>
                        <a href="{{ route('brand.banners.index', ['status' => 'approved']) }}" class="px-4 py-2 rounded-full font-bold text-sm transition {{ request('status') === 'approved' ? 'bg-blue-600 text-white' : 'bg-slate-50 text-slate-700 border border-slate-200 hover:bg-slate-100' }}">
                            Approved
                        </a>
                    </div>
                </form>
            </div>

            <!-- Banners List -->
            <div class="space-y-4">
                @forelse($banners as $banner)
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:shadow-md transition">
                        <div class="flex flex-col md:flex-row gap-6 items-start">
                            <!-- Thumbnail -->
                            <div class="flex-shrink-0 w-full md:w-48 h-32 rounded-lg overflow-hidden bg-slate-100 border border-slate-200">
                                <img src="{{ asset('storage/' . $banner->banner_image_url) }}" alt="{{ $banner->title }}" class="w-full h-full object-cover">
                            </div>

                            <!-- Content -->
                            <div class="flex-grow">
                                <div class="flex items-start gap-4 mb-3">
                                    <div>
                                        <h3 class="text-lg font-bold text-slate-900">{{ $banner->title }}</h3>
                                        <p class="text-slate-600 text-sm">{{ Str::limit($banner->description, 100) }}</p>
                                    </div>
                                    <div class="flex gap-2">
                                        @if($banner->isPending())
                                        <span class="px-3 py-1 bg-orange-100 text-orange-700 font-bold rounded-full text-xs whitespace-nowrap">⏳ Pending</span>
                                        @elseif($banner->isApproved())
                                        <span class="px-3 py-1 bg-blue-100 text-blue-700 font-bold rounded-full text-xs whitespace-nowrap">✓ Approved</span>
                                        @elseif($banner->isActive())
                                        <span class="px-3 py-1 bg-emerald-100 text-emerald-700 font-bold rounded-full text-xs whitespace-nowrap">● Active</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Stats -->
                                <div class="grid grid-cols-3 gap-4 mb-4 text-sm">
                                    <div>
                                        <p class="text-slate-600 text-xs font-bold uppercase">Clicks</p>
                                        <p class="font-bold text-slate-900">{{ $banner->clicks }}</p>
                                    </div>
                                    <div>
                                        <p class="text-slate-600 text-xs font-bold uppercase">Impressions</p>
                                        <p class="font-bold text-slate-900">{{ $banner->impressions }}</p>
                                    </div>
                                    <div>
                                        <p class="text-slate-600 text-xs font-bold uppercase">CTR</p>
                                        <p class="font-bold text-slate-900">{{ number_format($banner->ctr, 2) }}%</p>
                                    </div>
                                </div>

                                <!-- Dates -->
                                <p class="text-slate-600 text-xs mb-4">
                                    @if($banner->started_at && $banner->ended_at)
                                        {{ $banner->started_at->format('d M Y') }} - {{ $banner->ended_at->format('d M Y') }}
                                    @else
                                        Belum dijadwalkan
                                    @endif
                                </p>

                                <!-- Actions -->
                                <div class="flex gap-2 flex-wrap">
                                    <a href="{{ route('brand.banners.show', $banner) }}" class="px-4 py-2 bg-blue-50 text-blue-600 font-bold rounded-lg hover:bg-blue-100 transition text-sm">
                                        Detail
                                    </a>
                                    <a href="{{ route('brand.banners.edit', $banner) }}" class="px-4 py-2 bg-slate-50 text-slate-700 font-bold rounded-lg hover:bg-slate-100 transition text-sm border border-slate-200">
                                        Edit
                                    </a>
                                    <form id="deleteBannerForm{{ $banner->id }}" action="{{ route('brand.banners.delete', $banner) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                onclick="showDeleteBannerConfirm('{{ $banner->title }}', document.getElementById('deleteBannerForm{{ $banner->id }}'))"
                                                class="px-4 py-2 bg-red-50 text-red-600 font-bold rounded-lg hover:bg-red-100 transition text-sm">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center">
                        <svg class="w-12 h-12 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <h3 class="text-lg font-bold text-slate-900 mb-2">Belum Ada Banner</h3>
                        <p class="text-slate-600 mb-4">Mulai buat banner iklan untuk meningkatkan visibility brand Anda</p>
                        <a href="{{ route('brand.banners.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-slate-900 text-white rounded-full font-bold text-sm hover:bg-slate-800 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Buat Banner Pertama
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $banners->links() }}
            </div>
        </div>
    </div>
</x-layout>
