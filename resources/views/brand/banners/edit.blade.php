<x-layout>
    <x-slot:title>Edit Banner - {{ $banner->title }}</x-slot:title>

    <div class="min-h-screen bg-slate-50">
        <!-- Header -->
        <section class="bg-white border-b border-slate-200 py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <a href="{{ route('brand.banners.index') }}" class="text-blue-600 font-bold text-sm hover:text-blue-700 transition mb-4 inline-block">
                    ← Kembali ke Daftar Banner
                </a>
                <h1 class="text-3xl font-extrabold text-slate-900">Edit Banner</h1>
                <p class="text-slate-600 text-sm mt-1">Perbarui informasi dan gambar banner Anda</p>
            </div>
        </section>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <form action="{{ route('brand.banners.update', $banner) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl border border-slate-200 p-8 shadow-sm space-y-10">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2 space-y-6">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-bold text-slate-900">Informasi Dasar</h2>
                                <span class="text-xs font-semibold text-slate-500">Wajib diisi *</span>
                            </div>

                            <div class="space-y-5">
                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-slate-900">Judul Banner *</label>
                                    <input type="text" name="title" maxlength="100" required value="{{ old('title', $banner->title) }}"
                                           class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-sm"
                                           placeholder="Cth: Promo Diskon 50%">
                                    @if($errors->has('title'))
                                    <p class="text-red-600 text-xs mt-1 font-bold">{{ $errors->first('title') }}</p>
                                    @endif
                                    <p class="text-slate-600 text-xs">{{ strlen(old('title', $banner->title)) }}/100 karakter</p>
                                </div>

                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-slate-900">Deskripsi *</label>
                                    <textarea name="description" maxlength="255" required rows="3"
                                              class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-sm"
                                              placeholder="Jelaskan konten banner Anda...">{{ old('description', $banner->description) }}</textarea>
                                    @if($errors->has('description'))
                                    <p class="text-red-600 text-xs mt-1 font-bold">{{ $errors->first('description') }}</p>
                                    @endif
                                    <p class="text-slate-600 text-xs">{{ strlen(old('description', $banner->description)) }}/255 karakter</p>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <label class="text-sm font-bold text-slate-900">Teks Tombol CTA *</label>
                                        <input type="text" name="cta_text" maxlength="50" required value="{{ old('cta_text', $banner->cta_text) }}"
                                               class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-sm"
                                               placeholder="Cth: Lihat Produk, Belanja Sekarang">
                                        @if($errors->has('cta_text'))
                                        <p class="text-red-600 text-xs mt-1 font-bold">{{ $errors->first('cta_text') }}</p>
                                        @endif
                                        <p class="text-slate-600 text-xs">{{ strlen(old('cta_text', $banner->cta_text)) }}/50 karakter</p>
                                    </div>

                                    <div class="space-y-2">
                                        <label class="text-sm font-bold text-slate-900">Target Link *</label>
                                        <input type="url" name="link_url" required value="{{ old('link_url', $banner->link_url) }}"
                                               class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-sm"
                                               placeholder="https://example.com">
                                        @if($errors->has('link_url'))
                                        <p class="text-red-600 text-xs mt-1 font-bold">{{ $errors->first('link_url') }}</p>
                                        @endif
                                        <p class="text-slate-600 text-xs">Link akan dibuka saat user klik tombol CTA</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4 border-t border-slate-200 pt-6">
                            <h2 class="text-lg font-bold text-slate-900">Jadwal & Budget</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-slate-900">Tanggal Mulai</label>
                                    <input type="datetime-local" name="started_at" value="{{ old('started_at', $banner->started_at?->format('Y-m-d\TH:i')) }}"
                                           class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-sm">
                                    @if($errors->has('started_at'))
                                    <p class="text-red-600 text-xs mt-1 font-bold">{{ $errors->first('started_at') }}</p>
                                    @endif
                                </div>

                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-slate-900">Tanggal Berakhir</label>
                                    <input type="datetime-local" name="ended_at" value="{{ old('ended_at', $banner->ended_at?->format('Y-m-d\TH:i')) }}"
                                           class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-sm">
                                    @if($errors->has('ended_at'))
                                    <p class="text-red-600 text-xs mt-1 font-bold">{{ $errors->first('ended_at') }}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-900">Budget Iklan</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-3 text-slate-600 font-bold">Rp</span>
                                    <input type="number" name="budget" value="{{ old('budget', $banner->budget) }}"
                                           class="w-full px-4 py-3 pl-10 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-sm"
                                           placeholder="0">
                                </div>
                                @if($errors->has('budget'))
                                <p class="text-red-600 text-xs mt-1 font-bold">{{ $errors->first('budget') }}</p>
                                @endif
                                <p class="text-slate-600 text-xs">Opsional - Untuk referensi budget iklan Anda</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="text-lg font-bold text-slate-900">Gambar Banner *</h2>
                                    <p class="text-xs text-slate-600">Rekomendasi: 1200x400px (rasio 3:1), maksimal 5MB, format JPG/PNG/GIF</p>
                                    <p class="text-xs text-slate-500 mt-1">Minimum 1200x300px agar tidak terpotong saat tampil</p>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <p class="text-sm font-semibold text-slate-900">Gambar Saat Ini</p>
                                <div class="aspect-[3/1] bg-slate-100 rounded-xl overflow-hidden border border-slate-200">
                                    <img id="currentImage" src="{{ asset('storage/' . $banner->banner_image_url) }}" alt="{{ $banner->title }}" class="w-full h-full object-cover">
                                </div>
                            </div>

                            <div class="relative">
                                <input type="file" name="banner_image" accept="image/*" id="imageInput" class="hidden">
                                <label for="imageInput" id="dropZone" class="flex items-center justify-center w-full px-6 py-10 border-2 border-dashed border-slate-300 rounded-2xl cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition group">
                                    <div class="text-center space-y-2">
                                        <svg class="w-10 h-10 text-slate-400 group-hover:text-blue-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                        <div class="text-sm font-semibold text-slate-700">Klik atau drag & drop gambar</div>
                                        <div class="text-xs text-slate-500">Wajib: lebar ≥1200px, rasio 3:1, maks 5MB</div>
                                    </div>
                                </label>
                                @if($errors->has('banner_image'))
                                <p class="mt-2 text-xs text-red-600 font-bold">{{ $errors->first('banner_image') }}</p>
                                @endif

                                <div id="previewContainer" class="hidden mt-4">
                                    <p class="text-sm font-semibold text-slate-900 mb-2">Preview Gambar Baru</p>
                                    <div class="aspect-[3/1] bg-slate-100 rounded-xl overflow-hidden border border-slate-200">
                                        <img id="previewImage" class="w-full h-full object-cover">
                                    </div>
                                    <p class="text-xs text-slate-500 mt-2">Pastikan elemen penting (logo/CTA) berada di tengah agar tidak terpotong.</p>
                                </div>
                            </div>

                            <div class="bg-blue-50 rounded-xl border border-blue-200 p-4">
                                <p class="text-blue-900 text-sm leading-relaxed">
                                    <span class="font-bold">💡 Tip:</span> Simpan teks utama dan CTA di area tengah 70% supaya aman pada berbagai ukuran layar.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6">
                    <h4 class="font-bold text-blue-900 mb-3">ℹ Catatan Penting</h4>
                    <ul class="text-sm text-blue-800 space-y-2 list-disc list-inside">
                        <li>Perubahan akan di-review ulang oleh admin</li>
                        <li>Pastikan gambar mengikuti ukuran rekomendasi untuk menghindari crop</li>
                        <li>Hindari konten yang melanggar kebijakan kami</li>
                        <li>Kami akan memberikan feedback dalam 24 jam</li>
                    </ul>
                </div>

                <div class="flex flex-col md:flex-row gap-3">
                    <button type="submit" class="flex-1 px-6 py-3 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 transition">
                        💾 Simpan Perubahan
                    </button>
                    <a href="{{ route('brand.banners.show', $banner) }}" class="px-6 py-3 bg-slate-100 text-slate-700 font-bold rounded-xl hover:bg-slate-200 transition border border-slate-300 text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Image Preview
        const imageInput = document.getElementById('imageInput');
        const dropZone = document.getElementById('dropZone');
        const previewContainer = document.getElementById('previewContainer');
        const previewImage = document.getElementById('previewImage');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.classList.add('border-blue-500', 'bg-blue-50');
            });
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.classList.remove('border-blue-500', 'bg-blue-50');
            });
        });

        dropZone.addEventListener('drop', handleDrop);
        imageInput.addEventListener('change', handleFiles);

        function handleDrop(e) {
            const files = e.dataTransfer.files;
            imageInput.files = files;
            handleFiles({ target: { files } });
        }

        function handleFiles(e) {
            const files = e.target.files;
            if (files.length > 0) {
                const file = files[0];
                const reader = new FileReader();
                reader.onload = (event) => {
                    previewImage.src = event.target.result;
                    previewContainer.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        }

        // Character count
        document.querySelectorAll('input[maxlength], textarea[maxlength]').forEach(el => {
            el.addEventListener('input', function() {
                this.parentElement.querySelector('p:last-of-type').textContent = 
                    this.value.length + '/' + this.maxLength + ' karakter';
            });
        });
    </script>
</x-layout>
