<x-layout>
    <x-slot:title>Buat Banner Baru - Brand Dashboard</x-slot:title>

    <div class="min-h-screen bg-slate-50">
        <!-- Header -->
        <section class="relative overflow-hidden bg-white pb-12 pt-48 border-b border-slate-200">
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-50 rounded-full blur-3xl opacity-60 -mr-20 -mt-20 pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <a href="{{ route('brand.banners.index') }}" class="inline-flex items-center text-sm font-bold text-blue-600 hover:text-blue-700 mb-6 group">
                    <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Kembali ke Manajemen Banner
                </a>

                <div class="space-y-4">
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                        Buat Banner Iklan Baru
                    </h1>
                    <p class="text-base text-slate-600 max-w-2xl">
                        Buat kampanye iklan, promo, atau diskon untuk mempromosikan produk brand Anda.
                    </p>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="bg-white rounded-2xl border border-slate-200 p-8 shadow-sm">
                <form method="POST" action="{{ route('brand.banners.store') }}" enctype="multipart/form-data" class="space-y-10">
                    @csrf

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <div class="lg:col-span-2 space-y-6">
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <h2 class="text-lg font-bold text-slate-900">Detail Banner</h2>
                                    <span class="text-xs font-semibold text-slate-500">Wajib diisi *</span>
                                </div>
                                <div class="space-y-5">
                                    <div class="space-y-2">
                                        <label for="title" class="text-sm font-bold text-slate-700">Judul Banner *</label>
                                        <input id="title" name="title" type="text" required maxlength="100"
                                               class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-sm"
                                               placeholder="Contoh: Flash Sale 50% Discount" value="{{ old('title') }}">
                                        @error('title')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                    </div>

                                    <div class="space-y-2">
                                        <label for="description" class="text-sm font-bold text-slate-700">Deskripsi (Opsional)</label>
                                        <textarea id="description" name="description" rows="3" maxlength="255"
                                                  class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none text-sm"
                                                  placeholder="Deskripsi singkat tentang penawaran Anda...">{{ old('description') }}</textarea>
                                        @error('description')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="space-y-2">
                                            <label for="cta_text" class="text-sm font-bold text-slate-700">Tombol CTA *</label>
                                            <input id="cta_text" name="cta_text" type="text" required maxlength="50"
                                                   class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-sm"
                                                   placeholder="Contoh: Lihat Sekarang, Beli Sekarang" value="{{ old('cta_text', 'Lihat Sekarang') }}">
                                            @error('cta_text')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                        </div>
                                        <div class="space-y-2">
                                            <label for="link_url" class="text-sm font-bold text-slate-700">Link URL (Opsional)</label>
                                            <input id="link_url" name="link_url" type="url"
                                                   class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-sm"
                                                   placeholder="https://example.com" value="{{ old('link_url') }}">
                                            @error('link_url')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4 border-t border-slate-200 pt-6">
                                <h2 class="text-lg font-bold text-slate-900">Penjadwalan & Budget</h2>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <label for="started_at" class="text-sm font-bold text-slate-700">Tanggal Mulai</label>
                                        <input id="started_at" name="started_at" type="datetime-local"
                                               class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-sm"
                                               value="{{ old('started_at') }}">
                                        @error('started_at')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                    </div>
                                    <div class="space-y-2">
                                        <label for="ended_at" class="text-sm font-bold text-slate-700">Tanggal Berakhir</label>
                                        <input id="ended_at" name="ended_at" type="datetime-local"
                                               class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-sm"
                                               value="{{ old('ended_at') }}">
                                        @error('ended_at')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label for="budget" class="text-sm font-bold text-slate-700">Budget Kampanye (Opsional)</label>
                                    <div class="relative">
                                        <span class="absolute left-4 top-3 text-slate-600">Rp</span>
                                        <input id="budget" name="budget" type="number" step="1000" min="0"
                                               class="w-full pl-10 pr-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-sm"
                                               placeholder="Misalnya: 500000" value="{{ old('budget') }}">
                                    </div>
                                    @error('budget')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h2 class="text-lg font-bold text-slate-900">Gambar Banner *</h2>
                                        <p class="text-xs text-slate-600">Rekomendasi: 1200x400px, max 5MB (JPEG, PNG, GIF)</p>
                                    </div>
                                </div>

                                <div class="relative">
                                    <input id="banner_image" name="banner_image" type="file" required accept="image/*"
                                           class="hidden" onchange="updatePreview(this)">
                                    <label for="banner_image" class="flex items-center justify-center w-full px-6 py-10 border-2 border-dashed border-slate-300 rounded-2xl cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition group">
                                        <div class="text-center space-y-2">
                                            <svg class="w-10 h-10 text-slate-400 group-hover:text-blue-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                            <div class="text-sm font-semibold text-slate-700">Klik atau drag & drop gambar</div>
                                            <div class="text-xs text-slate-500">Format: JPG, PNG, GIF • Maks 5MB</div>
                                        </div>
                                    </label>
                                    <div id="preview" class="mt-4 hidden">
                                        <img id="previewImg" src="" alt="Preview" class="w-full max-h-64 object-cover rounded-xl border border-slate-200">
                                    </div>
                                    @error('banner_image')<p class="mt-2 text-xs text-red-600">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            <div class="bg-blue-50 rounded-xl border border-blue-200 p-4">
                                <p class="text-blue-900 text-sm leading-relaxed">
                                    <span class="font-bold">💡 Info:</span> Banner Anda akan di-review oleh admin sebelum ditampilkan. Proses review biasanya memakan waktu 1-2 jam.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col md:flex-row gap-3 pt-2">
                        <button type="submit" class="flex-1 px-6 py-3 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 transition">
                            Buat Banner
                        </button>
                        <a href="{{ route('brand.banners.index') }}" class="px-6 py-3 bg-slate-100 text-slate-700 font-bold rounded-xl hover:bg-slate-200 transition border border-slate-200 text-center">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function updatePreview(input) {
            const preview = document.getElementById('preview');
            const previewImg = document.getElementById('previewImg');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-layout>
