<x-layout>
    <x-slot:title>Detail Brand - Admin</x-slot:title>

    <div class="min-h-screen bg-slate-50">
        <section class="relative overflow-hidden bg-white pb-12 pt-48 border-b border-slate-200">
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-50 rounded-full blur-3xl opacity-60 -mr-20 -mt-20 pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <a href="{{ route('admin.brands') }}" class="inline-flex items-center text-sm font-bold text-blue-600 hover:text-blue-700 mb-6 group">
                    <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Kembali ke Manajemen Brand
                </a>

                <div class="space-y-4">
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                        Detail Brand Partner
                    </h1>
                    <p class="text-base text-slate-600">
                        Informasi lengkap tentang brand dan produknya.
                    </p>
                </div>
            </div>
        </section>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- BRAND CARD --}}
                <div class="bg-white rounded-2xl border border-slate-200 p-8">
                    @if($brand->logo_url)
                    <img src="{{ $brand->logo_url }}" alt="{{ $brand->brand_name }}" class="w-full h-48 rounded-xl object-cover mb-6 border border-slate-200">
                    @else
                    <div class="w-full h-48 rounded-xl bg-slate-100 flex items-center justify-center mb-6">
                        <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    @endif
                    
                    <h2 class="text-2xl font-bold text-slate-900 mb-2">{{ $brand->brand_name }}</h2>
                    
                    <div class="space-y-3 pt-6 border-t border-slate-200">
                        <div>
                            <p class="text-xs font-bold text-slate-600 uppercase mb-1">Status</p>
                            @if($brand->isPending())
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-orange-100 text-orange-700">⏳ Pending</span>
                            @elseif($brand->isApproved())
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-emerald-100 text-emerald-700">✓ Approved</span>
                            @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-red-100 text-red-700">✕ Rejected</span>
                            @endif
                            @if($brand->verified)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-blue-100 text-blue-700 ml-2">✓ Verified</span>
                            @endif
                        </div>

                        <div>
                            <p class="text-xs font-bold text-slate-600 uppercase mb-1">Terdaftar</p>
                            <p class="text-slate-900 font-medium">{{ $brand->created_at->format('d F Y') }}</p>
                        </div>

                        <div>
                            <p class="text-xs font-bold text-slate-600 uppercase mb-1">Pemilik</p>
                            <p class="text-slate-900 font-medium">{{ $owner->name }}</p>
                            <p class="text-xs text-slate-600">{{ $owner->email }}</p>
                        </div>
                    </div>

                    @if($brand->isPending())
                    <div class="mt-6 space-y-2">
                        <form action="{{ route('admin.brands.approve', $brand) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full px-4 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition">
                                ✓ Approve Brand
                            </button>
                        </form>
                        <form action="{{ route('admin.brands.reject', $brand) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full px-4 py-2.5 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition">
                                ✕ Reject Brand
                            </button>
                        </form>
                    </div>
                    @endif
                </div>

                {{-- DETAILS --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- LOGO UPLOAD --}}
                    <div class="bg-white rounded-2xl border border-slate-200 p-6">
                        <h3 class="text-lg font-bold text-slate-900 mb-4">Update Logo Brand</h3>
                        <form action="{{ route('admin.brands.update-logo', $brand) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            @method('PATCH')
                            
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Upload Logo Baru</label>
                                <input type="file" name="logo" accept="image/*" class="w-full px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                <p class="text-xs text-slate-500 mt-1">Format: JPG, PNG, atau SVG. Maksimal 2MB. Rekomendasi: 400x200px</p>
                            </div>

                            <button type="submit" class="w-full px-4 py-2.5 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition">
                                📤 Upload Logo
                            </button>
                        </form>
                    </div>

                    {{-- DESCRIPTION --}}
                    <div class="bg-white rounded-2xl border border-slate-200 p-6">
                        <h3 class="text-lg font-bold text-slate-900 mb-4">Deskripsi</h3>
                        <p class="text-slate-600 leading-relaxed">{{ $brand->description ?? 'Belum ada deskripsi' }}</p>
                    </div>

                    {{-- STATISTICS --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white rounded-2xl border border-slate-200 p-6">
                            <p class="text-sm text-slate-600 mb-2">Total Produk</p>
                            <p class="text-3xl font-bold text-blue-600">{{ $products }}</p>
                        </div>
                        <div class="bg-white rounded-2xl border border-slate-200 p-6">
                            <p class="text-sm text-slate-600 mb-2">Status Verifikasi</p>
                            <p class="text-lg font-bold text-slate-900">{{ $brand->verified ? '✓ Verified' : '✗ Not Verified' }}</p>
                        </div>
                    </div>

                    {{-- OWNER INFO --}}
                    <div class="bg-white rounded-2xl border border-slate-200 p-6">
                        <h3 class="text-lg font-bold text-slate-900 mb-4">Informasi Pemilik</h3>
                        <div class="space-y-4">
                            <div>
                                <p class="text-xs font-bold text-slate-600 uppercase mb-1">Nama</p>
                                <p class="text-slate-900 font-medium">{{ $owner->name }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-600 uppercase mb-1">Email</p>
                                <p class="text-slate-900 font-medium">{{ $owner->email }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-600 uppercase mb-1">Role</p>
                                <p class="text-slate-900 font-medium">{{ ucfirst(str_replace('_', ' ', $owner->role)) }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-600 uppercase mb-1">Status Akun</p>
                                @if($owner->is_premium)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-purple-100 text-purple-700">⭐ Premium</span>
                                @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-slate-100 text-slate-700">Free</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- DANGER ZONE --}}
                    <div class="bg-red-50 rounded-2xl border border-red-200 p-6">
                        <h3 class="text-lg font-bold text-red-900 mb-4">⚠️ Zona Bahaya</h3>
                        <p class="text-red-700 text-sm mb-4">Tindakan berikut tidak dapat dibatalkan. Pastikan Anda yakin sebelum melanjutkan.</p>
                        <form id="deleteBrandForm" action="{{ route('admin.brands.delete', $brand) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="showDeleteBrandConfirm('{{ addslashes($brand->brand_name) }}', document.getElementById('deleteBrandForm'))" class="w-full px-4 py-2.5 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition">
                                🗑️ Hapus Brand Selamanya
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
