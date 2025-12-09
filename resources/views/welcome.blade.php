<x-layout>
    {{-- HERO --}}
    <section class="py-20 bg-gradient-to-b from-brand-bg via-brand-bg to-brand-beige">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                <div class="space-y-6">
                    <h1 class="text-5xl sm:text-6xl font-extrabold text-brand-dark leading-tight">Scan your look, Find your fit!</h1>
                    <p class="text-gray-700 max-w-xl text-lg">Temukan inspirasi outfit terbaik hanya dengan satu foto.</p>
                    <div>
                        <a href="#" class="inline-block mt-6 text-white px-8 py-4 rounded-lg shadow-md hover:shadow-lg transition font-semibold text-base" style="background-color: #1a2332;">Coba Sekarang</a>
                    </div>
                </div>

                <div class="flex justify-center md:justify-end">
                    <img src="{{ asset('images/hero-phone.png') }}" alt="App Mockup" class="w-full max-w-sm mx-auto -rotate-6 hover:rotate-0 transition-transform duration-500 drop-shadow-lg">
                </div>
            </div>
        </div>
    </section>

    {{-- AI OUTFIT SCANNER --}}
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center gap-12">
                <div class="md:w-1/2 flex justify-center">
                    <img src="{{ asset('images/icon_scanner.png') }}" alt="AI Scanner" class="w-64 mx-auto">
                </div>
                <div class="md:w-1/2">
                    <h2 class="text-4xl font-bold text-brand-dark mb-4">AI Outfit Scanner</h2>
                    <p class="text-gray-600 leading-relaxed text-lg">Unggah foto OOTD-mu, dan biarkan AI menemukan produk yang serupa. Dapatkan rekomendasi produk yang sesuai dengan gaya dan warnamu dalam hitungan detik.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- FITUR KAMI --}}
    <section class="py-20 bg-brand-bg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h3 class="text-center text-3xl font-bold text-brand-dark mb-12">Temukan Gaya Terbaikmu dengan Fitur Kami</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white border border-gray-300 rounded-2xl p-6 hover:shadow-xl transition-shadow">
                    <img src="{{ asset('images/icon-profile.png') }}" alt="Personalisasi" class="h-14 mb-4">
                    <h4 class="font-bold text-gray-900">Personalisasi Fashion Profile</h4>
                    <p class="text-sm text-gray-600 mt-2">Rekomendasi sesuai gaya user.</p>
                </div>

                <div class="bg-white border border-gray-300 rounded-2xl p-6 hover:shadow-xl transition-shadow">
                    <img src="{{ asset('images/icon_trend.png') }}" alt="Trend" class="h-14 mb-4">
                    <h4 class="font-bold text-gray-900">Trend & Fashion Terbaru</h4>
                    <p class="text-sm text-gray-600 mt-2">Update trend fashionmu.</p>
                </div>

                <div class="bg-white border border-gray-300 rounded-2xl p-6 hover:shadow-xl transition-shadow">
                    <img src="{{ asset('images/icon-shop.png') }}" alt="Marketplace" class="h-14 mb-4">
                    <h4 class="font-bold text-gray-900">Marketplace Integration</h4>
                    <p class="text-sm text-gray-600 mt-2">Langsung belanja dari rekomendasi.</p>
                </div>

                <div class="bg-white border border-gray-300 rounded-2xl p-6 hover:shadow-xl transition-shadow">
                    <img src="{{ asset('images/icon-star.png') }}" alt="Dashboard" class="h-14 mb-4">
                    <h4 class="font-bold text-gray-900">Dashboard User</h4>
                    <p class="text-sm text-gray-600 mt-2">Simpan favorit dan wishlist.</p>
                </div>
            </div>
        </div>
    </section>

    
    {{-- STATISTIK --}}
    <section class="py-16" style="background-color: #1a2332;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-white">
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 text-center">
                <div class="py-6">
                    <div class="text-4xl font-bold">100+</div>
                    <div class="text-sm mt-1">Brand Terdaftar</div>
                </div>

                <div class="py-6">
                    <div class="text-4xl font-bold">5.000+</div>
                    <div class="text-sm mt-1">Outfit Dianalisis</div>
                </div>

                <div class="py-6">
                    <div class="text-4xl font-bold">98%</div>
                    <div class="text-sm mt-1">Akurasi AI</div>
                </div>

                <div class="py-6">
                    <div class="text-4xl font-bold">24/7</div>
                    <div class="text-sm mt-1">Akses</div>
                </div>
            </div>
        </div>
    </section>

    {{-- MITRA BRAND (carousel) --}}
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h3 class="text-center text-3xl font-bold text-brand-dark mb-12">Bekerja sama dengan Brand Lokal Terbaik</h3>

            <style>
                .marquee { overflow: hidden; }
                .marquee-track { display:flex; gap:2rem; align-items:center; animation:marquee 18s linear infinite; }
                .marquee-track > div { flex: 0 0 auto; }
                @keyframes marquee { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
            </style>

            <div class="marquee mb-12">
                <div class="marquee-track">
                    @for ($i = 1; $i <= 6; $i++)
                        <div class="w-36 h-20 bg-gray-100 rounded-lg flex items-center justify-center">
                            <img src="{{ asset('images/brand-' . $i . '.png') }}" alt="Brand {{ $i }}" class="max-h-12 object-contain grayscale hover:grayscale-0 transition duration-300">
                        </div>
                    @endfor
                    {{-- duplicate for smooth loop --}}
                    @for ($i = 1; $i <= 6; $i++)
                        <div class="w-36 h-20 bg-gray-100 rounded-lg flex items-center justify-center">
                            <img src="{{ asset('images/brand-' . $i . '.png') }}" alt="Brand dup {{ $i }}" class="max-h-12 object-contain grayscale hover:grayscale-0 transition duration-300">
                        </div>
                    @endfor
                </div>
            </div>

            {{-- CTA Card untuk Brand Partner --}}
            <div class="bg-slate-50 border-2 border-dashed border-brand-secondary rounded-2xl p-8 sm:p-12 text-center max-w-2xl mx-auto">
                <h4 class="text-2xl sm:text-3xl font-bold text-brand-dark mb-3">Punya Brand Fashion? Jadilah Partner Kami!</h4>
                <p class="text-gray-600 text-base mb-6">Jangkau ribuan pengguna ScanFit dan tingkatkan penjualanmu.</p>
                <a href="/register?role=brand" class="inline-block px-8 py-3 border-2 border-brand-dark text-brand-dark font-semibold rounded-lg hover:bg-brand-dark hover:text-white transition duration-300">
                    Gabung Jadi Brand Partner
                </a>
            </div>
        </div>
    </section>

    {{-- CTA AKHIR --}}
    <section class="py-16" style="background-color: #1a2332;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-white text-center">
            <h3 class="text-3xl sm:text-4xl font-bold mb-4">Siap Tampil Lebih Percaya Diri?</h3>
            <p class="text-lg text-white/90 mb-6">Mulai eksplorasi gaya dan temukan padanan yang tepat untukmu.</p>
            <a href="/scan" 
                class="inline-block px-8 py-3 rounded-lg font-bold shadow text-[#2F4156] border-2 border-transparent hover:bg-[#2F4156] hover:text-white transition" 
                style="background-color: #F5F5DC;">
                Mulai Scan Sekarang
            </a>
        </div>
    </section>

</x-layout>