<x-layout>
    <x-slot:title>Hasil Scan Outfit</x-slot:title>

    <div class="min-h-screen bg-slate-50">
        <!-- Header (match Explore top spacing) -->
        <section class="relative overflow-hidden bg-white pb-12 pt-48 border-b border-slate-200">
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-50 rounded-full blur-3xl opacity-60 -mr-20 -mt-20 pointer-events-none"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center md:text-left space-y-3">
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100">Hasil Analisis AI</span>
                    <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-slate-900">Outfit kamu sudah dianalisis</h1>
                    <p class="text-base md:text-lg text-slate-600 max-w-2xl">Lihat detail gaya dan rekomendasi produk yang paling cocok.</p>
                </div>
            </div>
        </section>

        <!-- Content -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-10">
            <!-- Hero Layout -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                <!-- Foto Upload + quick chips -->
                <div class="xl:col-span-2 bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="relative">
                        <img src="{{ asset('storage/' . $scan->image_path) }}" alt="Uploaded Outfit" class="w-full h-[460px] object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/70 via-transparent to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-6 flex flex-wrap gap-3">
                            <span class="inline-flex items-center gap-2 px-3 py-2 rounded-full bg-white/90 backdrop-blur text-slate-900 text-sm font-semibold shadow-sm border border-white">
                                <span class="inline-block w-2 h-2 rounded-full bg-emerald-500"></span>
                                {{ $scanData['confidence'] }}% akurat
                            </span>
                            <span class="inline-flex items-center gap-2 px-3 py-2 rounded-full bg-white/90 backdrop-blur text-slate-900 text-sm font-semibold shadow-sm border border-white">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                                {{ $scanData['style_name'] }}
                            </span>
                            <span class="inline-flex items-center gap-2 px-3 py-2 rounded-full bg-white/90 backdrop-blur text-slate-900 text-sm font-semibold shadow-sm border border-white">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                {{ count($scanData['clothing_items'] ?? []) }} items
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Panel Analisis Ringkas -->
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 space-y-6">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-[0.2em]">Gaya Teridentifikasi</p>
                            <h2 class="text-2xl font-bold text-slate-900 mt-2">{{ $scanData['style_name'] }}</h2>
                            <p class="text-slate-600 mt-2 leading-relaxed">{{ $scanData['description'] }}</p>
                            @if(!empty($scanData['mood']))
                            <div class="mt-3 inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 border border-blue-200">
                                <span class="text-xs font-semibold text-blue-700">✨ {{ $scanData['mood'] }}</span>
                            </div>
                            @endif
                        </div>
                        <div class="relative w-20 h-20 flex items-center justify-center" aria-label="Confidence ring">
                            @php $confidence = (int) $scanData['confidence']; @endphp
                            <div class="absolute inset-0 rounded-full" style="background: conic-gradient(#2563eb {{ $confidence }}%, #e5e7eb {{ $confidence }}%);"></div>
                            <div class="absolute inset-[6px] bg-white rounded-full border border-slate-200"></div>
                            <div class="relative text-center">
                                <span class="text-sm font-bold text-slate-900">{{ $confidence }}%</span>
                                <p class="text-[10px] text-slate-500 -mt-1">confidence</p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4">
                        <p class="text-xs font-semibold text-slate-500">Item terdeteksi</p>
                        <p class="text-2xl font-extrabold text-slate-900 mt-1">{{ !empty($scanData['clothing_items']) ? count($scanData['clothing_items']) : 0 }}</p>
                        <p class="text-xs text-slate-500 mt-1">Total kategori pakaian</p>
                    </div>
                </div>
            </div>

            <!-- Section Rekomendasi -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8 space-y-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-[0.2em]">Rekomendasi</p>
                        <h2 class="text-2xl font-bold text-slate-900">Produk yang serasi</h2>
                        <p class="text-sm text-slate-500">Dipilih berdasarkan gaya dan kecocokan siluet.</p>
                    </div>
                    <a href="{{ route('explore.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-slate-900 text-white text-sm font-semibold hover:-translate-y-0.5 transition shadow-lg shadow-slate-900/20">
                        Lihat semua produk
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                    @forelse($recommendations as $product)
                        @php
                            $isArray = is_array($product);
                            $price = $isArray ? $product['price'] : $product->price;
                            $image = $isArray ? $product['image_url'] : $product->image_url;
                            $name = $isArray ? $product['name'] : $product->name;
                            $brand = $isArray ? ($product['brand']['name'] ?? 'Brand') : ($product->brand->name ?? 'Brand');
                            $id = $isArray ? $product['id'] : $product->id;
                        @endphp
                        <div class="group bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 flex flex-col overflow-hidden">
                            <div class="relative aspect-[4/5] overflow-hidden bg-slate-100">
                                <img src="{{ $image }}" alt="{{ $name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                <div class="absolute top-3 left-3 px-3 py-1 rounded-full text-[10px] font-bold bg-white/90 text-slate-900 border border-white shadow-sm">{{ $brand }}</div>
                                <div class="absolute bottom-3 right-3 px-3 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 border border-emerald-200">Match</div>
                            </div>
                            <div class="p-4 flex flex-col flex-grow">
                                <h4 class="text-slate-900 font-bold text-sm leading-snug line-clamp-2 mb-1 group-hover:text-blue-600 transition">{{ $name }}</h4>
                                <div class="mt-auto pt-3 border-t border-slate-100 flex items-end gap-2">
                                    <span class="text-slate-900 font-extrabold text-base">Rp {{ number_format($price, 0, ',', '.') }}</span>
                                </div>
                                <div class="mt-3 flex gap-2">
                                    <a href="{{ route('products.show', $id) }}" class="flex-1 inline-flex items-center justify-center px-3 py-2 rounded-lg border border-slate-200 text-sm font-semibold text-slate-700 hover:border-slate-900 transition">Detail</a>
                                    <button onclick="saveToCloset({{ $id }})" class="flex-1 inline-flex items-center justify-center px-3 py-2 rounded-lg text-sm font-semibold text-white bg-slate-900 hover:bg-slate-800 shadow-sm transition">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                        </svg>
                                        Simpan
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12">
                            <p class="text-slate-500">Tidak ada rekomendasi tersedia saat ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Footer Action -->
            <div class="text-center">
                <a href="{{ route('scan.index') }}" class="inline-flex items-center gap-2 px-8 py-4 rounded-full text-lg font-semibold bg-gradient-to-r from-slate-900 to-blue-700 text-white shadow-lg shadow-blue-900/20 hover:-translate-y-0.5 transition">
                    Lakukan Scan Baru
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>
        </section>
    </div>

    <script>
        async function saveToCloset(itemId) {
            try {
                const response = await fetch('/closet/save', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ item_id: itemId })
                });

                const data = await response.json();

                if (response.ok) {
                    alert('Berhasil ditambahkan ke Closet!');
                } else if (response.status === 401) {
                    window.location.href = '/login';
                } else if (response.status === 409) {
                    alert('Item sudah ada di closet!');
                } else {
                    alert('Gagal menyimpan.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan.');
            }
        }
    </script>
</x-layout>