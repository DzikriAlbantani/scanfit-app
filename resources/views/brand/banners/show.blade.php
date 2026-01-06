<x-layout>
    <x-slot:title>Detail Banner - {{ $banner->title }}</x-slot:title>

    <div class="min-h-screen bg-slate-50">
        <!-- Header -->
        <section class="bg-white border-b border-slate-200 py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <div>
                        <a href="{{ route('brand.banners.index') }}" class="text-blue-600 font-bold text-sm hover:text-blue-700 transition mb-4 inline-block">
                            ← Kembali ke Daftar Banner
                        </a>
                        <h1 class="text-3xl font-extrabold text-slate-900">{{ $banner->title }}</h1>
                        <p class="text-slate-600 text-sm mt-1">Dibuat {{ $banner->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="text-right">
                        @if($banner->isPending())
                        <span class="inline-block px-4 py-2 bg-orange-100 text-orange-700 font-bold rounded-full text-sm mb-3">⏳ Menunggu Review Admin</span>
                        @elseif($banner->isApproved())
                        <span class="inline-block px-4 py-2 bg-blue-100 text-blue-700 font-bold rounded-full text-sm mb-3">✓ Disetujui Admin</span>
                        @elseif($banner->isActive())
                        <span class="inline-block px-4 py-2 bg-emerald-100 text-emerald-700 font-bold rounded-full text-sm mb-3">● Aktif & Ditampilkan</span>
                        @elseif($banner->isRejected())
                        <span class="inline-block px-4 py-2 bg-red-100 text-red-700 font-bold rounded-full text-sm mb-3">✕ Ditolak</span>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Banner Image & Info -->
                <div class="lg:col-span-2">
                    <!-- Banner Image -->
                    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm mb-8">
                        <div class="aspect-video bg-slate-200 overflow-hidden flex items-center justify-center">
                            <img src="{{ asset('storage/' . $banner->banner_image_url) }}" alt="{{ $banner->title }}" class="w-full h-full object-cover">
                        </div>
                    </div>

                    <!-- Banner Details -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-8 shadow-sm">
                        <h2 class="text-xl font-bold text-slate-900 mb-6">Informasi Banner</h2>

                        <!-- Description -->
                        <div class="mb-6 pb-6 border-b border-slate-200">
                            <p class="text-sm text-slate-600 font-bold uppercase mb-2">Deskripsi</p>
                            <p class="text-slate-900 text-base leading-relaxed">{{ $banner->description }}</p>
                        </div>

                        <!-- CTA -->
                        <div class="mb-6 pb-6 border-b border-slate-200">
                            <p class="text-sm text-slate-600 font-bold uppercase mb-2">Tombol CTA</p>
                            <p class="text-slate-900 font-bold">{{ $banner->cta_text }}</p>
                        </div>

                        <!-- Link URL -->
                        <div class="mb-6 pb-6 border-b border-slate-200">
                            <p class="text-sm text-slate-600 font-bold uppercase mb-2">Target Link</p>
                            <a href="{{ $banner->link_url }}" target="_blank" class="text-blue-600 font-bold text-sm hover:text-blue-700 transition break-all">
                                {{ $banner->link_url }} <span class="text-xs">↗</span>
                            </a>
                        </div>

                        <!-- Schedule -->
                        @if($banner->started_at || $banner->ended_at)
                        <div class="mb-6 pb-6 border-b border-slate-200">
                            <p class="text-sm text-slate-600 font-bold uppercase mb-4">Jadwal Tampil</p>
                            <div class="grid grid-cols-2 gap-4">
                                @if($banner->started_at)
                                <div>
                                    <p class="text-slate-600 text-xs font-bold uppercase mb-1">Mulai</p>
                                    <p class="text-slate-900 font-bold">{{ $banner->started_at->format('d M Y H:i') }}</p>
                                </div>
                                @endif
                                @if($banner->ended_at)
                                <div>
                                    <p class="text-slate-600 text-xs font-bold uppercase mb-1">Berakhir</p>
                                    <p class="text-slate-900 font-bold">{{ $banner->ended_at->format('d M Y H:i') }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif

                        <!-- Budget -->
                        @if($banner->budget)
                        <div>
                            <p class="text-sm text-slate-600 font-bold uppercase mb-2">Budget Iklan</p>
                            <p class="text-slate-900 font-bold text-lg">Rp {{ number_format($banner->budget, 0, ',', '.') }}</p>
                        </div>
                        @endif
                    </div>

                    <!-- Rejection Reason -->
                    @if($banner->rejection_reason)
                    <div class="bg-red-50 border border-red-200 rounded-2xl p-8 mt-8">
                        <h3 class="text-lg font-bold text-red-900 mb-3">⚠ Alasan Penolakan</h3>
                        <p class="text-red-800">{{ $banner->rejection_reason }}</p>
                        <p class="text-red-700 text-sm mt-4">Silakan edit banner Anda dan upload ulang untuk di-review kembali.</p>
                    </div>
                    @endif
                </div>

                <!-- Analytics Sidebar -->
                <div>
                    <!-- Status Card -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm mb-6">
                        <h3 class="text-lg font-bold text-slate-900 mb-4">Status</h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-xs text-slate-600 font-bold uppercase mb-1">Status Saat Ini</p>
                                <div class="flex items-center gap-2">
                                    @if($banner->isPending())
                                    <span class="w-3 h-3 bg-orange-500 rounded-full"></span>
                                    <span class="font-bold text-slate-900">Menunggu Review</span>
                                    @elseif($banner->isApproved())
                                    <span class="w-3 h-3 bg-blue-500 rounded-full"></span>
                                    <span class="font-bold text-slate-900">Disetujui</span>
                                    @elseif($banner->isActive())
                                    <span class="w-3 h-3 bg-emerald-500 rounded-full"></span>
                                    <span class="font-bold text-slate-900">Aktif</span>
                                    @elseif($banner->isRejected())
                                    <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                                    <span class="font-bold text-slate-900">Ditolak</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Analytics -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm mb-6">
                        <h3 class="text-lg font-bold text-slate-900 mb-4">Analitik</h3>
                        <div class="space-y-4">
                            <div>
                                <p class="text-xs text-slate-600 font-bold uppercase mb-1">Impressions</p>
                                <p class="text-2xl font-bold text-blue-600">{{ $banner->impressions }}</p>
                                <p class="text-xs text-slate-600 mt-1">Kali tampil</p>
                            </div>
                            <div class="border-t border-slate-200 pt-4">
                                <p class="text-xs text-slate-600 font-bold uppercase mb-1">Clicks</p>
                                <p class="text-2xl font-bold text-emerald-600">{{ $banner->clicks }}</p>
                                <p class="text-xs text-slate-600 mt-1">Kali diklik</p>
                            </div>
                            <div class="border-t border-slate-200 pt-4">
                                <p class="text-xs text-slate-600 font-bold uppercase mb-1">CTR (Click Through Rate)</p>
                                <p class="text-2xl font-bold text-purple-600">{{ number_format($banner->ctr, 2) }}%</p>
                                <p class="text-xs text-slate-600 mt-1">Persentase klik</p>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="space-y-3">
                        @if($banner->isRejected() || $banner->isPending())
                        <a href="{{ route('brand.banners.edit', $banner) }}" class="block w-full px-6 py-3 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition text-center">
                            ✎ Edit Banner
                        </a>
                        @endif
                        <form id="deleteBannerForm{{ $banner->id }}" action="{{ route('brand.banners.delete', $banner) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button"
                                    onclick="showDeleteBannerConfirm('{{ $banner->title }}', document.getElementById('deleteBannerForm{{ $banner->id }}'))"
                                    class="block w-full px-6 py-3 bg-red-50 text-red-600 font-bold rounded-lg hover:bg-red-100 transition text-center border border-red-200">
                                🗑 Hapus Banner
                            </button>
                        </form>
                    </div>

                    <!-- Paid Placement Status -->
                    <div class="mt-6 bg-amber-50 border border-amber-200 rounded-2xl p-6">
                        <h4 class="font-bold text-amber-900 mb-3">Penayangan Berbayar</h4>
                        @php
                            $activePlacement = \App\Models\BannerPlacement::where('banner_id', $banner->id)->active()->latest()->first();
                        @endphp
                        @if($activePlacement)
                            <p class="text-sm text-amber-800">Aktif sampai <span class="font-bold">{{ \Carbon\Carbon::parse($activePlacement->end_date)->format('d M Y') }}</span>.</p>
                            <a href="{{ route('brand.bannerPlacements.create', $banner) }}" class="inline-block mt-3 px-4 py-2 bg-amber-600 text-white rounded-lg font-bold">Perpanjang Penayangan</a>
                        @else
                            <p class="text-sm text-amber-800">Belum ada penayangan berbayar aktif.</p>
                            <a href="{{ route('brand.bannerPlacements.create', $banner) }}" class="inline-block mt-3 px-4 py-2 bg-amber-600 text-white rounded-lg font-bold">Beli Hari Penayangan</a>
                        @endif
                        <div class="mt-4">
                            <h5 class="font-bold text-amber-900 mb-2">Riwayat Penayangan</h5>
                            @php
                                $placements = \App\Models\BannerPlacement::where('banner_id', $banner->id)->latest()->take(5)->get();
                            @endphp
                            @if($placements->isEmpty())
                                <p class="text-sm text-amber-800">Belum ada riwayat.</p>
                            @else
                                <ul class="text-sm text-amber-900 space-y-2">
                                    @foreach($placements as $p)
                                        <li class="flex items-center justify-between">
                                            <span>{{ \Carbon\Carbon::parse($p->start_date)->format('d M') }}–{{ \Carbon\Carbon::parse($p->end_date)->format('d M Y') }} ({{ $p->days ?? 0 }} hari)</span>
                                            <span class="font-bold {{ $p->status === 'active' ? 'text-emerald-700' : ($p->status === 'expired' ? 'text-slate-700' : 'text-amber-700') }}">{{ ucfirst($p->status) }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>

                    <!-- Info Box -->
                    <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6 mt-6">
                        <h4 class="font-bold text-blue-900 mb-3">ℹ Info Penting</h4>
                        <ul class="text-sm text-blue-800 space-y-2 list-disc list-inside">
                            <li>Banner harus di-approve admin sebelum ditampilkan</li>
                            <li>Rata-rata approval: 24 jam</li>
                            <li>Ikuti panduan konten yang berlaku</li>
                            <li>Kualitas gambar minimal 1200x300px</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
