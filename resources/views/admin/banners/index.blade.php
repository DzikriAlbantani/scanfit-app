<x-layout>
    <x-slot:title>Manajemen Banner Iklan - Admin</x-slot:title>

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
                        Review dan kelola semua kampanye iklan dari brand partner.
                    </p>
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
                    <p class="text-sm text-slate-600 font-bold uppercase mb-2">Pending</p>
                    <p class="text-3xl font-bold text-orange-600">{{ $stats['pending_banners'] }}</p>
                </div>
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                    <p class="text-sm text-slate-600 font-bold uppercase mb-2">Approved</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $stats['approved_banners'] }}</p>
                </div>
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                    <p class="text-sm text-slate-600 font-bold uppercase mb-2">Active</p>
                    <p class="text-3xl font-bold text-emerald-600">{{ $stats['active_banners'] }}</p>
                </div>
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                    <p class="text-sm text-slate-600 font-bold uppercase mb-2">Total Clicks</p>
                    <p class="text-3xl font-bold text-purple-600">{{ $stats['total_clicks'] }}</p>
                </div>
            </div>

            <!-- Search & Filter -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm mb-6">
                <form action="{{ route('admin.banners.index') }}" method="GET" class="space-y-4">
                    <div class="flex flex-col md:flex-row gap-4 items-center">
                        <div class="flex-grow">
                            <input type="text" name="search" placeholder="Cari judul banner atau brand..."
                                   value="{{ request('search') }}"
                                   class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-sm">
                        </div>
                        <button type="submit" class="px-6 py-2.5 bg-slate-900 text-white font-bold rounded-lg hover:bg-slate-800 transition text-sm whitespace-nowrap">
                            Cari
                        </button>
                    </div>

                    <div class="w-full overflow-x-auto">
                        <div class="flex gap-2 flex-wrap md:flex-nowrap min-w-max pb-1">
                            <a href="{{ route('admin.banners.index') }}" class="px-4 py-2 rounded-full font-bold text-sm transition whitespace-nowrap {{ !request('status') ? 'bg-slate-900 text-white' : 'bg-slate-50 text-slate-700 border border-slate-200 hover:bg-slate-100' }}">
                                Semua
                            </a>
                            <a href="{{ route('admin.banners.index', ['status' => 'pending']) }}" class="px-4 py-2 rounded-full font-bold text-sm transition whitespace-nowrap {{ request('status') === 'pending' ? 'bg-orange-600 text-white' : 'bg-slate-50 text-slate-700 border border-slate-200 hover:bg-slate-100' }}">
                                Pending Review
                            </a>
                            <a href="{{ route('admin.banners.index', ['status' => 'approved']) }}" class="px-4 py-2 rounded-full font-bold text-sm transition whitespace-nowrap {{ request('status') === 'approved' ? 'bg-blue-600 text-white' : 'bg-slate-50 text-slate-700 border border-slate-200 hover:bg-slate-100' }}">
                                Approved
                            </a>
                            <a href="{{ route('admin.banners.index', ['status' => 'active']) }}" class="px-4 py-2 rounded-full font-bold text-sm transition whitespace-nowrap {{ request('status') === 'active' ? 'bg-emerald-600 text-white' : 'bg-slate-50 text-slate-700 border border-slate-200 hover:bg-slate-100' }}">
                                Active
                            </a>
                        </div>
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
                                <div class="flex items-start justify-between mb-3">
                                    <div>
                                        <h3 class="text-lg font-bold text-slate-900">{{ $banner->title }}</h3>
                                        <p class="text-slate-600 text-sm">Brand: <strong>{{ $banner->brand->brand_name }}</strong></p>
                                        <p class="text-slate-600 text-sm">Owner: <strong>{{ $banner->brand->user->name }}</strong></p>
                                    </div>
                                    <div>
                                        @if($banner->isPending())
                                        <span class="px-3 py-1 bg-orange-100 text-orange-700 font-bold rounded-full text-xs">⏳ Pending</span>
                                        @elseif($banner->isApproved())
                                        <span class="px-3 py-1 bg-blue-100 text-blue-700 font-bold rounded-full text-xs">✓ Approved</span>
                                        @elseif($banner->isActive())
                                        <span class="px-3 py-1 bg-emerald-100 text-emerald-700 font-bold rounded-full text-xs">● Active</span>
                                        @elseif($banner->isRejected())
                                        <span class="px-3 py-1 bg-red-100 text-red-700 font-bold rounded-full text-xs">✕ Rejected</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Stats -->
                                <div class="grid grid-cols-4 gap-4 mb-4 text-sm">
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
                                    <div>
                                        <p class="text-slate-600 text-xs font-bold uppercase">Created</p>
                                        <p class="font-bold text-slate-900 text-xs">{{ $banner->created_at->format('d M') }}</p>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="flex gap-2 flex-wrap">
                                    <a href="{{ route('admin.banners.show', $banner) }}" class="px-4 py-2 bg-blue-50 text-blue-600 font-bold rounded-lg hover:bg-blue-100 transition text-sm">
                                        Detail
                                    </a>
                                    @if($banner->isPending())
                                        <form action="{{ route('admin.banners.approve', $banner) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-4 py-2 bg-emerald-50 text-emerald-600 font-bold rounded-lg hover:bg-emerald-100 transition text-sm">
                                                ✓ Approve
                                            </button>
                                        </form>
                                        <button onclick="showRejectForm({{ $banner->id }})" class="px-4 py-2 bg-red-50 text-red-600 font-bold rounded-lg hover:bg-red-100 transition text-sm">
                                            ✕ Reject
                                        </button>
                                    @elseif($banner->isApproved())
                                        <form action="{{ route('admin.banners.activate', $banner) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-4 py-2 bg-emerald-50 text-emerald-600 font-bold rounded-lg hover:bg-emerald-100 transition text-sm">
                                                ● Activate
                                            </button>
                                        </form>
                                    @elseif($banner->isActive())
                                        <form action="{{ route('admin.banners.deactivate', $banner) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-4 py-2 bg-slate-50 text-slate-600 font-bold rounded-lg hover:bg-slate-100 transition text-sm border border-slate-200">
                                                ○ Deactivate
                                            </button>
                                        </form>
                                    @endif
                                </div>

                                @if($banner->rejection_reason)
                                <div class="mt-4 p-4 bg-red-50 rounded-lg border border-red-200">
                                    <p class="text-red-900 text-sm"><strong>Alasan Penolakan:</strong> {{ $banner->rejection_reason }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Reject Modal -->
                    <div id="rejectForm{{ $banner->id }}" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
                        <div class="bg-white rounded-2xl p-6 max-w-md w-full">
                            <h3 class="text-lg font-bold text-slate-900 mb-4">Tolak Banner</h3>
                            <form action="{{ route('admin.banners.reject', $banner) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <textarea name="rejection_reason" required rows="4"
                                          class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-sm mb-4"
                                          placeholder="Berikan alasan penolakan..."></textarea>
                                <div class="flex gap-2">
                                    <button type="submit" class="flex-grow px-4 py-2.5 bg-red-600 text-white font-bold rounded-lg hover:bg-red-700 transition">
                                        Tolak
                                    </button>
                                    <button type="button" onclick="hideRejectForm({{ $banner->id }})" class="px-4 py-2.5 bg-slate-100 text-slate-700 font-bold rounded-lg hover:bg-slate-200 transition">
                                        Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center">
                        <svg class="w-12 h-12 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <h3 class="text-lg font-bold text-slate-900 mb-2">Belum Ada Banner</h3>
                        <p class="text-slate-600">Tidak ada banner yang sesuai dengan filter Anda</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $banners->links() }}
            </div>
        </div>
    </div>

    <script>
        function showRejectForm(bannerId) {
            document.getElementById('rejectForm' + bannerId).classList.remove('hidden');
        }
        function hideRejectForm(bannerId) {
            document.getElementById('rejectForm' + bannerId).classList.add('hidden');
        }
    </script>
</x-layout>
