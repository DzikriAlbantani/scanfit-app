<x-layout>
    <x-slot:title>Detail Banner Admin - {{ $banner->title }}</x-slot:title>

    <div class="min-h-screen bg-slate-50">
        <!-- Header -->
        <section class="bg-white border-b border-slate-200 py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <div>
                        <a href="{{ route('admin.banners.index') }}" class="text-blue-600 font-bold text-sm hover:text-blue-700 transition mb-4 inline-block">
                            ← Kembali ke Daftar Banner
                        </a>
                        <h1 class="text-3xl font-extrabold text-slate-900">{{ $banner->title }}</h1>
                        <p class="text-slate-600 text-sm mt-1">Brand: <strong>{{ $banner->brand->brand_name }}</strong> • Owner: <strong>{{ $banner->brand->user->name }}</strong></p>
                    </div>
                    <div class="text-right">
                        @if($banner->isPending())
                        <span class="inline-block px-4 py-2 bg-orange-100 text-orange-700 font-bold rounded-full text-sm">⏳ Pending Review</span>
                        @elseif($banner->isApproved())
                        <span class="inline-block px-4 py-2 bg-blue-100 text-blue-700 font-bold rounded-full text-sm">✓ Approved</span>
                        @elseif($banner->isActive())
                        <span class="inline-block px-4 py-2 bg-emerald-100 text-emerald-700 font-bold rounded-full text-sm">● Active</span>
                        @elseif($banner->isRejected())
                        <span class="inline-block px-4 py-2 bg-red-100 text-red-700 font-bold rounded-full text-sm">✕ Rejected</span>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Banner Content -->
                <div class="lg:col-span-2">
                    <!-- Banner Image -->
                    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm mb-8">
                        <div class="aspect-video bg-slate-200 overflow-hidden flex items-center justify-center">
                            <img src="{{ asset('storage/' . $banner->banner_image_url) }}" alt="{{ $banner->title }}" class="w-full h-full object-cover">
                        </div>
                    </div>

                    <!-- Banner Details -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-8 shadow-sm">
                        <h2 class="text-xl font-bold text-slate-900 mb-6">Detail Banner</h2>

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
                            <p class="text-sm text-slate-600 font-bold uppercase mb-2">Budget</p>
                            <p class="text-slate-900 font-bold text-lg">Rp {{ number_format($banner->budget, 0, ',', '.') }}</p>
                        </div>
                        @endif
                    </div>

                    <!-- Rejection Reason (if any) -->
                    @if($banner->rejection_reason)
                    <div class="bg-red-50 border border-red-200 rounded-2xl p-8 mt-8">
                        <h3 class="text-lg font-bold text-red-900 mb-3">⚠ Alasan Penolakan Sebelumnya</h3>
                        <p class="text-red-800">{{ $banner->rejection_reason }}</p>
                    </div>
                    @endif
                </div>

                <!-- Admin Actions Sidebar -->
                <div>
                    <!-- Analytics -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm mb-6">
                        <h3 class="text-lg font-bold text-slate-900 mb-4">Analitik</h3>
                        <div class="space-y-4">
                            <div>
                                <p class="text-xs text-slate-600 font-bold uppercase mb-1">Impressions</p>
                                <p class="text-2xl font-bold text-blue-600">{{ $banner->impressions }}</p>
                            </div>
                            <div class="border-t border-slate-200 pt-4">
                                <p class="text-xs text-slate-600 font-bold uppercase mb-1">Clicks</p>
                                <p class="text-2xl font-bold text-emerald-600">{{ $banner->clicks }}</p>
                            </div>
                            <div class="border-t border-slate-200 pt-4">
                                <p class="text-xs text-slate-600 font-bold uppercase mb-1">CTR</p>
                                <p class="text-2xl font-bold text-purple-600">{{ number_format($banner->ctr, 2) }}%</p>
                            </div>
                        </div>
                    </div>

                    <!-- Brand Info -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm mb-6">
                        <h3 class="text-lg font-bold text-slate-900 mb-4">Informasi Brand</h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-xs text-slate-600 font-bold uppercase mb-1">Nama Brand</p>
                                <p class="text-slate-900 font-bold">{{ $banner->brand->brand_name }}</p>
                            </div>
                            <div class="border-t border-slate-200 pt-3">
                                <p class="text-xs text-slate-600 font-bold uppercase mb-1">Pemilik</p>
                                <p class="text-slate-900 font-bold">{{ $banner->brand->user->name }}</p>
                            </div>
                            <div class="border-t border-slate-200 pt-3">
                                <p class="text-xs text-slate-600 font-bold uppercase mb-1">Email</p>
                                <a href="mailto:{{ $banner->brand->user->email }}" class="text-blue-600 font-bold text-sm hover:text-blue-700 transition">
                                    {{ $banner->brand->user->email }}
                                </a>
                            </div>
                            <div class="border-t border-slate-200 pt-3">
                                <p class="text-xs text-slate-600 font-bold uppercase mb-1">Status Brand</p>
                                <span class="inline-block px-3 py-1 bg-emerald-100 text-emerald-700 font-bold rounded-full text-xs">
                                    ✓ {{ ucfirst($banner->brand->status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Admin Actions -->
                    @if($banner->isPending())
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm mb-6">
                        <h3 class="text-lg font-bold text-slate-900 mb-4">Review Diperlukan</h3>
                        <div class="space-y-3">
                            <form action="{{ route('admin.banners.approve', $banner) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="w-full px-4 py-3 bg-emerald-600 text-white font-bold rounded-lg hover:bg-emerald-700 transition text-sm">
                                    ✓ Approve Banner
                                </button>
                            </form>
                            <button type="button" onclick="showRejectForm()" class="w-full px-4 py-3 bg-red-50 text-red-600 font-bold rounded-lg hover:bg-red-100 transition text-sm border border-red-200">
                                ✕ Reject Banner
                            </button>
                        </div>
                    </div>

                    <!-- Reject Form -->
                    <div id="rejectForm" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
                        <div class="bg-white rounded-2xl p-6 max-w-md w-full">
                            <h3 class="text-lg font-bold text-slate-900 mb-4">Tolak Banner</h3>
                            <form action="{{ route('admin.banners.reject', $banner) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <textarea name="rejection_reason" required rows="4"
                                          class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-sm mb-4"
                                          placeholder="Jelaskan alasan penolakan..."></textarea>
                                <div class="flex gap-2">
                                    <button type="submit" class="flex-grow px-4 py-2.5 bg-red-600 text-white font-bold rounded-lg hover:bg-red-700 transition">
                                        Tolak
                                    </button>
                                    <button type="button" onclick="hideRejectForm()" class="px-4 py-2.5 bg-slate-100 text-slate-700 font-bold rounded-lg hover:bg-slate-200 transition">
                                        Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @elseif($banner->isApproved())
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm mb-6">
                        <h3 class="text-lg font-bold text-slate-900 mb-4">Status: Approved</h3>
                        <form action="{{ route('admin.banners.activate', $banner) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full px-4 py-3 bg-emerald-600 text-white font-bold rounded-lg hover:bg-emerald-700 transition text-sm">
                                ● Activate Banner
                            </button>
                        </form>
                    </div>
                    @elseif($banner->isActive())
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm mb-6">
                        <h3 class="text-lg font-bold text-slate-900 mb-4">Status: Active</h3>
                        <form action="{{ route('admin.banners.deactivate', $banner) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full px-4 py-3 bg-slate-100 text-slate-600 font-bold rounded-lg hover:bg-slate-200 transition text-sm border border-slate-200">
                                ○ Deactivate Banner
                            </button>
                        </form>
                    </div>
                    @elseif($banner->isRejected())
                    <div class="bg-red-50 rounded-2xl border border-red-200 p-6 mb-6">
                        <h3 class="text-lg font-bold text-red-900 mb-3">⚠ Status: Rejected</h3>
                        <p class="text-red-800 text-sm mb-4">Banner ini telah ditolak. Brand perlu mengubah konten dan mengajukan ulang.</p>
                    </div>
                    @endif

                    <!-- Delete Action -->
                    <form id="deleteBannerForm{{ $banner->id }}" action="{{ route('admin.banners.delete', $banner) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" 
                                onclick="showDeleteBannerConfirm('{{ $banner->title }}', document.getElementById('deleteBannerForm{{ $banner->id }}'))"
                                class="w-full px-4 py-3 bg-red-50 text-red-600 font-bold rounded-lg hover:bg-red-100 transition text-sm border border-red-200">
                            🗑 Hapus Banner
                        </button>
                    </form>

                    <!-- Info Box -->
                    <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6 mt-6">
                        <h4 class="font-bold text-blue-900 mb-3">Workflow Approval</h4>
                        <ol class="text-sm text-blue-800 space-y-2 list-decimal list-inside">
                            <li>Review konten banner</li>
                            <li>Approve atau reject</li>
                            <li>Jika approved, activate banner</li>
                            <li>Banner muncul di homepage</li>
                            <li>Monitor analytics & CTR</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showRejectForm() {
            document.getElementById('rejectForm').classList.remove('hidden');
        }
        function hideRejectForm() {
            document.getElementById('rejectForm').classList.add('hidden');
        }
    </script>
</x-layout>
