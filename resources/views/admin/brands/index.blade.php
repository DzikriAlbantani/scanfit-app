<x-layout>
    <x-slot:title>Manajemen Brand - Admin</x-slot:title>

    <div class="min-h-screen bg-slate-50">
        <section class="relative overflow-hidden bg-white pb-12 pt-48 border-b border-slate-200">
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-50 rounded-full blur-3xl opacity-60 -mr-20 -mt-20 pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="space-y-4 text-center md:text-left">
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                        Manajemen <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">Brand Partner</span>
                    </h1>
                    <p class="text-base text-slate-600 max-w-2xl mx-auto md:mx-0">
                        Review dan kelola aplikasi brand partner yang bergabung.
                    </p>
                </div>

                <div class="mt-8 flex flex-col md:flex-row gap-4 items-center justify-between">
                    <form action="{{ route('admin.brands') }}" method="GET" class="relative w-full md:max-w-md group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400 group-focus-within:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari brand atau pemilik..." 
                               class="block w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-full text-base text-slate-900 placeholder-slate-400 focus:border-slate-900 focus:ring-0 transition-all shadow-sm hover:border-slate-300">
                    </form>

                    <div class="flex gap-2">
                        <a href="{{ route('admin.brands') }}" class="flex items-center gap-2 px-5 py-2.5 rounded-full font-bold text-sm transition-all whitespace-nowrap border shadow-sm {{ !request('status') ? 'bg-slate-900 text-white border-slate-900' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">
                            Semua ({{ $stats['pending'] + $stats['approved'] + $stats['rejected'] }})
                        </a>
                        <a href="{{ route('admin.brands', ['status' => 'pending']) }}" class="flex items-center gap-2 px-5 py-2.5 rounded-full font-bold text-sm transition-all whitespace-nowrap border shadow-sm {{ request('status') === 'pending' ? 'bg-orange-600 text-white border-orange-600' : 'bg-white text-orange-600 border-orange-200 hover:bg-orange-50' }}">
                            ⏳ Pending ({{ $stats['pending'] }})
                        </a>
                        <a href="{{ route('admin.brands', ['status' => 'approved']) }}" class="flex items-center gap-2 px-5 py-2.5 rounded-full font-bold text-sm transition-all whitespace-nowrap border shadow-sm {{ request('status') === 'approved' ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-white text-emerald-600 border-emerald-200 hover:bg-emerald-50' }}">
                            ✓ Approved ({{ $stats['approved'] }})
                        </a>
                        <a href="{{ route('admin.brands', ['status' => 'rejected']) }}" class="flex items-center gap-2 px-5 py-2.5 rounded-full font-bold text-sm transition-all whitespace-nowrap border shadow-sm {{ request('status') === 'rejected' ? 'bg-red-600 text-white border-red-600' : 'bg-white text-red-600 border-red-200 hover:bg-red-50' }}">
                            ✕ Rejected ({{ $stats['rejected'] }})
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 gap-6">
                @forelse($brands as $brand)
                <div class="bg-white rounded-2xl border border-slate-200 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-start gap-4 flex-1">
                            @if($brand->logo_url)
                            <img src="{{ $brand->logo_url }}" alt="{{ $brand->brand_name }}" class="w-16 h-16 rounded-xl object-cover border border-slate-200">
                            @else
                            <div class="w-16 h-16 rounded-xl bg-slate-100 flex items-center justify-center">
                                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            @endif
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-slate-900">{{ $brand->brand_name }}</h3>
                                <p class="text-sm text-slate-600 mb-2">Pemilik: <span class="font-semibold">{{ $brand->user->name }}</span></p>
                                <p class="text-sm text-slate-600">{{ Str::limit($brand->description, 100) }}</p>
                                <div class="mt-3 flex gap-2">
                                    @if($brand->verified)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-700">✓ Verified</span>
                                    @endif
                                    @if($brand->isPending())
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-orange-100 text-orange-700">⏳ Pending Review</span>
                                    @elseif($brand->isApproved())
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">✓ Approved</span>
                                    @elseif($brand->isRejected())
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-700">✕ Rejected</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-slate-500 mb-2">{{ $brand->created_at->format('d M Y') }}</p>
                            <a href="{{ route('admin.brands.show', $brand) }}" class="text-blue-600 text-sm font-semibold hover:underline">Detail →</a>
                        </div>
                    </div>

                    @if($brand->isPending())
                    <div class="flex gap-3 pt-4 border-t border-slate-200">
                        <form action="{{ route('admin.brands.approve', $brand) }}" method="POST" class="flex-1">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full px-4 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition">
                                ✓ Approve
                            </button>
                        </form>
                        <form action="{{ route('admin.brands.reject', $brand) }}" method="POST" class="flex-1">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full px-4 py-2.5 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition">
                                ✕ Reject
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
                @empty
                <div class="bg-white rounded-2xl border border-slate-200 py-16 text-center">
                    <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <h3 class="text-lg font-bold text-slate-900 mb-1">Tidak Ada Brand</h3>
                    <p class="text-slate-600">Belum ada brand yang daftar dengan kriteria ini</p>
                </div>
                @endforelse
            </div>

            @if($brands->hasPages())
            <div class="mt-12">
                {{ $brands->links() }}
            </div>
            @endif
        </div>
    </div>
</x-layout>
