<x-layout title="ScanFit - Scan your look, Find your fit">
    {{-- HERO SECTION --}}
    <section class="py-20 lg:py-32 bg-gradient-to-b from-[#C8D9E6]/50 via-white to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                <div class="space-y-6">
                    <h1 class="text-5xl sm:text-6xl font-extrabold text-brand-dark leading-tight">
                        Scan your look, Find your fit!
                    </h1>
                    <p class="text-lg text-gray-700 max-w-xl">
                        Temukan inspirasi outfit terbaik hanya dengan satu foto. AI kami akan menemukan produk yang cocok dengan gaya dan warnamu.
                    </p>
                    <div>
                        <a href="/dashboard" class="inline-flex items-center px-8 py-4 bg-brand-dark text-white rounded-full font-bold shadow-lg hover:shadow-xl hover:bg-brand-dark/90 transition duration-300">
                            Coba Sekarang
                        </a>
                    </div>
                </div>

                <div class="flex justify-center md:justify-end">
                    <img src="{{ asset('images/hero-phone.png') }}" alt="App Mockup" class="w-full max-w-sm mx-auto -rotate-6 hover:rotate-0 transition-transform duration-500 drop-shadow-lg">
                </div>
            </div>
        </div>
    </section>

    {{-- AI OUTFIT SCANNER SECTION --}}
    <section class="py-20 bg-white my-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center gap-12">
                <div class="md:w-1/2 flex justify-center">
                    <img src="{{ asset('images/icon_scanner.png') }}" alt="AI Scanner" class="w-64 mx-auto">
                </div>
                <div class="space-y-4">
                    <h2 class="text-4xl sm:text-5xl font-bold text-brand-dark leading-tight">
                        AI Outfit Scanner
                    </h2>
                    <p class="text-lg text-gray-700 leading-relaxed">
                        Unggah foto OOTD-mu, dan biarkan AI menemukan produk yang serupa. Dapatkan rekomendasi produk yang sesuai dengan gaya dan warnamu dalam hitungan detik.
                    </p>

                </div>
            </div>
        </div>
    </section>

    {{-- FITUR KAMI --}}
    <section class="py-20 bg-brand-bg my-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-center text-4xl font-bold text-brand-dark mb-16">
                Temukan Gaya Terbaikmu dengan Fitur Kami
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Feature 1 --}}
                <div class="bg-white border border-gray-300 rounded-2xl p-8 hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 rounded-full bg-brand-bg flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-brand-dark" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                    </div>
                    <h4 class="font-bold text-lg text-gray-900 mb-2">Personalisasi Fashion Profile</h4>
                    <p class="text-sm text-gray-600">Rekomendasi yang disesuaikan dengan gaya dan preferensi unikmu.</p>
                </div>

                <div class="bg-white border border-gray-300 rounded-2xl p-8 hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 rounded-full bg-brand-bg flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-brand-dark" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <h4 class="font-bold text-lg text-gray-900 mb-2">Trend & Fashion Terbaru</h4>
                    <p class="text-sm text-gray-600">Selalu update dengan trend fashion terkini dan rekomendasi editor.</p>
                </div>

                {{-- Feature 3 --}}
                <div class="bg-white border border-gray-300 rounded-2xl p-8 hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 rounded-full bg-brand-bg flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-brand-dark" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-0.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-0.9-2-2-2z"/>
                        </svg>
                    </div>
                    <h4 class="font-bold text-lg text-gray-900 mb-2">Marketplace Integration</h4>
                    <p class="text-sm text-gray-600">Belanja langsung dari rekomendasi produk kami dengan sekali klik.</p>
                </div>

                {{-- Feature 4 --}}
                <div class="bg-white border border-gray-300 rounded-2xl p-8 hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 rounded-full bg-brand-bg flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-brand-dark" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.72-7 8.77V12H5V6.3l7-3.11v8.8z"/>
                        </svg>
                    </div>
                    <h4 class="font-bold text-lg text-gray-900 mb-2">Dashboard User</h4>
                    <p class="text-sm text-gray-600">Simpan favorit, manage wishlist, dan lihat riwayat rekomendasi.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- STATISTIK SECTION --}}
    <section class="py-20" style="background-color: #2F4156;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 text-white text-center">
                <div class="py-8">
                    <div class="text-5xl font-extrabold">100+</div>
                    <p class="text-lg mt-3">Brand Lokal Terdaftar</p>
                </div>

                <div class="py-8">
                    <div class="text-5xl font-extrabold">5.000+</div>
                    <p class="text-lg mt-3">Outfit Dianalisis</p>
                </div>

                <div class="py-8">
                    <div class="text-5xl font-extrabold">98%</div>
                    <p class="text-lg mt-3">Akurasi AI</p>
                </div>

                <div class="py-8">
                    <div class="text-5xl font-extrabold">24/7</div>
                    <p class="text-lg mt-3">Akses 24 Jam Penuh</p>
                </div>
            </div>
        </div>
    </section>

    {{-- MITRA BRAND SECTION --}}
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-center text-4xl font-bold text-brand-dark mb-16">
                Bekerja sama dengan Brand Lokal Terbaik
            </h2>

            <style>
                .marquee { overflow: hidden; background: white; }
                .marquee-track { display: flex; gap: 2rem; align-items: center; animation: marquee 20s linear infinite; }
                .marquee-track > div { flex: 0 0 auto; }
                @keyframes marquee { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
            </style>

            <div class="marquee mb-16">
                <div class="marquee-track">
                    @for ($i = 1; $i <= 5; $i++)
                        <div class="flex-shrink-0">
                            <img src="https://placehold.co/150x60/e2e8f0/475569?text=Brand+{{ $i }}" 
                                 alt="Brand {{ $i }}" 
                                 class="h-16 object-contain opacity-60 hover:opacity-100 transition-opacity duration-300 filter hover:grayscale-0">
                        </div>
                    @endfor
                    {{-- duplicate for smooth loop --}}
                    @for ($i = 1; $i <= 5; $i++)
                        <div class="flex-shrink-0">
                            <img src="https://placehold.co/150x60/e2e8f0/475569?text=Brand+{{ $i }}" 
                                 alt="Brand {{ $i }}" 
                                 class="h-16 object-contain opacity-60 hover:opacity-100 transition-opacity duration-300 filter hover:grayscale-0">
                        </div>
                    @endfor
                </div>
            </div>

            {{-- CTA CARD --}}
            <div class="bg-gradient-to-br from-brand-bg/30 to-brand-beige/30 border-2 border-dashed border-brand-secondary rounded-3xl p-12 text-center max-w-3xl mx-auto">
                <h3 class="text-3xl sm:text-4xl font-bold text-brand-dark mb-4">
                    Punya Brand Fashion? Jadilah Partner Kami!
                </h3>
                <p class="text-lg text-gray-700 mb-8">
                    Jangkau ribuan pengguna ScanFit dan tingkatkan penjualanmu dengan partnership eksklusif.
                </p>
                <a href="/register?role=brand" class="inline-flex items-center px-8 py-4 border-2 border-brand-dark text-brand-dark font-bold rounded-full hover:bg-brand-dark hover:text-white transition duration-300">
                    Gabung Jadi Brand Partner
                </a>
            </div>
        </div>
    </section>

    {{-- FINAL CTA SECTION --}}
    <section class="py-20" style="background: linear-gradient(135deg, #2F4156 0%, #1e293b 100%);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-white text-center">
            <h2 class="text-4xl sm:text-5xl font-bold mb-6">
                Siap Tampil Lebih Percaya Diri?
            </h2>
            <p class="text-xl text-white/90 mb-10 max-w-2xl mx-auto">
                Mulai eksplorasi gaya dan temukan padanan yang tepat untukmu hari ini. Bergabunglah dengan ribuan pengguna yang sudah merasakan manfaatnya.
            </p>
            <a href="/dashboard" 
                class="inline-flex items-center px-10 py-4 rounded-full font-bold shadow-lg text-brand-dark bg-brand-beige hover:shadow-xl hover:scale-105 transition duration-300">
                Mulai Scan Sekarang
            </a>
        </div>
    </section>

</x-layout>