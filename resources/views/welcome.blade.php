<x-layout title="ScanFit - Scan your look, Find your fit">

    {{-- CSS KHUSUS ANIMASI --}}
    <style>
        /* 1. Animasi Marquee (Logo Bergerak) */
        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .animate-marquee {
            display: flex;
            width: max-content;
            animation: marquee 40s linear infinite; /* Kecepatan sedang agar nyaman dibaca */
        }
        .marquee-wrapper:hover .animate-marquee {
            animation-play-state: paused;
        }

        /* 2. Animasi Muncul (Fade In Up) */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in-up { animation: fadeInUp 1s ease-out forwards; }
        .delay-100 { animation-delay: 0.1s; opacity: 0; animation-fill-mode: forwards; }
        .delay-200 { animation-delay: 0.2s; opacity: 0; animation-fill-mode: forwards; }
        .delay-300 { animation-delay: 0.3s; opacity: 0; animation-fill-mode: forwards; }

        /* 3. Animasi Floating (Melayang) */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-float-delayed { 
            animation: float 6s ease-in-out infinite; 
            animation-delay: 3s; 
        }
    </style>
    
    {{-- HERO SECTION --}}
    <section class="relative pt-48 pb-20 lg:pb-32 overflow-hidden bg-white">
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-blue-100 rounded-full blur-3xl opacity-50 animate-pulse"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 bg-purple-100 rounded-full blur-3xl opacity-50 animate-pulse" style="animation-delay: 2s"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                
                <div class="space-y-8 text-center lg:text-left order-2 lg:order-1">
                    <div class="inline-block bg-blue-50 text-brand-dark px-4 py-1.5 rounded-full text-sm font-bold tracking-wide mb-2 border border-blue-100 fade-in-up">
                        ✨ #1 AI Fashion Assistant di Indonesia
                    </div>
                    <h1 class="text-5xl sm:text-6xl font-extrabold text-slate-900 leading-tight fade-in-up delay-100">
                        Bingung Mau Pakai Baju Apa? <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Scan Aja!</span>
                    </h1>
                    <p class="text-lg text-gray-600 max-w-xl mx-auto lg:mx-0 leading-relaxed fade-in-up delay-200">
                        Cukup upload satu foto, AI kami akan mencarikan outfit dari brand lokal terbaik yang 100% cocok dengan gaya, warna kulit, dan budgetmu.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start fade-in-up delay-300">
                        <a href="{{ route('register') }}" class="group relative inline-flex items-center justify-center px-8 py-4 bg-slate-900 text-white rounded-full font-bold shadow-lg overflow-hidden transition-all duration-300 hover:shadow-blue-500/30 hover:-translate-y-1">
                            <span class="relative z-10">Coba Scan Gratis</span>
                            <div class="absolute inset-0 h-full w-full scale-0 rounded-full transition-all duration-300 group-hover:scale-100 group-hover:bg-blue-600/20"></div>
                        </a>
                        <a href="#how-it-works" class="inline-flex items-center justify-center px-8 py-4 border-2 border-slate-200 text-slate-700 rounded-full font-bold hover:border-slate-900 hover:text-slate-900 transition duration-300">
                            Lihat Cara Kerja
                        </a>
                    </div>
                </div>

                <div class="relative flex justify-center lg:justify-end order-1 lg:order-2 fade-in-up delay-300">
                    <div class="relative w-72 md:w-80"> <img src="{{ asset('images/hero-phone.png') }}" alt="App Mockup" class="w-full relative z-10 drop-shadow-2xl transition-transform duration-500 hover:scale-105">
                        
                        <div class="absolute top-20 -left-16 z-20 bg-white/95 backdrop-blur-sm p-4 rounded-xl shadow-xl border border-gray-100 flex items-center gap-3 animate-float w-48">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-600 flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <p class="text-[10px] uppercase text-gray-500 font-bold tracking-wider">AI Match</p>
                                <p class="text-sm font-bold text-slate-900">98% Casual Fit</p>
                            </div>
                        </div>

                        <div class="absolute bottom-32 -right-12 z-20 bg-white/95 backdrop-blur-sm p-4 rounded-xl shadow-xl border border-gray-100 flex items-center gap-3 animate-float-delayed w-52">
                            <div class="w-10 h-10 rounded-full overflow-hidden border border-gray-200 bg-gray-100 flex-shrink-0">
                                <img src="https://ui-avatars.com/api/?name=LB&background=2563EB&color=fff" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <p class="text-[10px] uppercase text-gray-500 font-bold tracking-wider">Brand Found</p>
                                <p class="text-sm font-bold text-slate-900">Local Brand</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- BANNER CAROUSEL MOVED TO USER DASHBOARD --}}
    {{-- See /resources/views/dashboard.blade.php for banner carousel --}}

    {{-- BRAND PARTNERS (CARD STYLE MARQUEE) --}}
    <section class="py-16 bg-gray-50 border-y border-gray-200 overflow-hidden">
        <div class="max-w-full">
            <p class="text-center text-xs font-bold text-gray-400 uppercase tracking-[0.2em] mb-10">Dipercaya oleh Brand Lokal Favoritmu</p>
            
            <div class="marquee-wrapper relative w-full overflow-hidden">
                <div class="animate-marquee flex items-center gap-8 pl-8">
                    @forelse($brands as $brand)
                        @if($brand && $brand->logo_url)
                        <div class="flex-shrink-0 w-48 h-24 bg-white border border-gray-200 rounded-xl shadow-sm flex items-center justify-center p-4 hover:shadow-md hover:border-blue-200 transition-all duration-300 group">
                            <img src="{{ $brand->logo_url }}" 
                                 class="max-w-full max-h-full object-contain opacity-60 grayscale group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-300" 
                                 alt="{{ $brand->name ?? $brand->brand_name ?? 'Brand' }}">
                        </div>
                        @endif
                    @empty
                        @for ($i = 0; $i < 6; $i++) 
                            <div class="flex-shrink-0 w-48 h-24 bg-white border border-gray-200 rounded-xl shadow-sm flex items-center justify-center p-4 hover:shadow-md hover:border-blue-200 transition-all duration-300 group">
                                <img src="https://placehold.co/120x40/white/0f172a?text=BRAND+{{$i+1}}" 
                                     class="max-w-full max-h-full object-contain opacity-60 grayscale group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-300" 
                                     alt="Brand Logo">
                            </div>
                        @endfor
                    @endforelse
                    {{-- DUPLIKASI UNTUK LOOPING --}}
                    @foreach($brands as $brand)
                        @if($brand && $brand->logo_url)
                        <div class="flex-shrink-0 w-48 h-24 bg-white border border-gray-200 rounded-xl shadow-sm flex items-center justify-center p-4 hover:shadow-md hover:border-blue-200 transition-all duration-300 group">
                            <img src="{{ $brand->logo_url }}" 
                                 class="max-w-full max-h-full object-contain opacity-60 grayscale group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-300" 
                                 alt="{{ $brand->name ?? $brand->brand_name ?? 'Brand' }}">
                        </div>
                        @endif
                    @endforeach
                </div>
                
                <div class="absolute inset-y-0 left-0 w-32 bg-gradient-to-r from-gray-50 to-transparent z-10"></div>
                <div class="absolute inset-y-0 right-0 w-32 bg-gradient-to-l from-gray-50 to-transparent z-10"></div>
            </div>
        </div>
    </section>

    {{-- HOW IT WORKS --}}
    <section id="how-it-works" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 mb-4">Gimana Cara Kerjanya?</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Cuma butuh 3 langkah sederhana. Teknologi AI kami yang bekerja untukmu.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div class="group bg-white p-8 rounded-2xl shadow-sm border border-gray-100 text-center hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                    <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-2xl font-bold mx-auto mb-6 group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">1</div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Upload Foto</h3>
                    <p class="text-gray-600 leading-relaxed">Ambil foto OOTD kamu di cermin atau upload foto inspirasi outfit dari Pinterest/Instagram.</p>
                </div>
                <div class="group bg-white p-8 rounded-2xl shadow-sm border border-gray-100 text-center hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                    <div class="w-16 h-16 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center text-2xl font-bold mx-auto mb-6 group-hover:scale-110 group-hover:bg-purple-600 group-hover:text-white transition-all duration-300">2</div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">AI Menganalisa</h3>
                    <p class="text-gray-600 leading-relaxed">Teknologi kami mendeteksi jenis pakaian, warna dominan, dan gaya (Casual, Formal, dll).</p>
                </div>
                <div class="group bg-white p-8 rounded-2xl shadow-sm border border-gray-100 text-center hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                    <div class="w-16 h-16 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center text-2xl font-bold mx-auto mb-6 group-hover:scale-110 group-hover:bg-green-600 group-hover:text-white transition-all duration-300">3</div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Dapat Rekomendasi</h3>
                    <p class="text-gray-600 leading-relaxed">Voila! Muncul daftar produk dari brand lokal yang mirip dengan fotomu, siap untuk dibeli.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- FITUR UTAMA --}}
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="order-2 lg:order-1 relative group">
                    <div class="absolute inset-0 bg-gradient-to-tr from-blue-600 to-purple-600 rounded-3xl transform rotate-3 opacity-20 group-hover:rotate-6 transition-transform duration-500"></div>
                    <img src="https://images.unsplash.com/photo-1483985988355-763728e1935b?q=80&w=1200&auto=format&fit=crop" alt="Shopping Feature" class="relative rounded-3xl shadow-2xl transform -rotate-2 group-hover:rotate-0 transition-transform duration-500">
                </div>
                <div class="order-1 lg:order-2 space-y-8">
                    <h2 class="text-3xl sm:text-4xl font-bold text-slate-900">Kenapa Harus Pakai ScanFit?</h2>
                    <div class="space-y-6">
                        <div class="flex gap-4 p-4 rounded-xl hover:bg-gray-50 transition-colors duration-300">
                            <div class="flex-shrink-0 w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-slate-900 mb-1">Akurasi Tinggi</h3>
                                <p class="text-gray-600">AI kami dilatih dengan ribuan dataset fashion lokal untuk hasil yang presisi.</p>
                            </div>
                        </div>
                        <div class="flex gap-4 p-4 rounded-xl hover:bg-gray-50 transition-colors duration-300">
                            <div class="flex-shrink-0 w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center text-orange-600 shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-slate-900 mb-1">Langsung Beli</h3>
                                <p class="text-gray-600">Terintegrasi langsung dengan Shopee & Tokopedia Official Store brand terkait.</p>
                            </div>
                        </div>
                        <div class="flex gap-4 p-4 rounded-xl hover:bg-gray-50 transition-colors duration-300">
                            <div class="flex-shrink-0 w-12 h-12 bg-pink-50 rounded-xl flex items-center justify-center text-pink-600 shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-slate-900 mb-1">My Closet</h3>
                                <p class="text-gray-600">Simpan hasil scan favoritmu ke dalam lemari digital untuk dilihat nanti.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- STATISTIK & TESTIMONI & CTA --}}
    <section class="py-20 bg-slate-900 text-white relative overflow-hidden group">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10 transition-transform duration-1000 group-hover:scale-110"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div class="hover:-translate-y-2 transition-transform duration-300">
                    <div class="text-4xl lg:text-5xl font-extrabold text-blue-400 mb-2">10+</div>
                    <p class="text-slate-400 font-medium">Brand Lokal</p>
                </div>
                <div class="hover:-translate-y-2 transition-transform duration-300">
                    <div class="text-4xl lg:text-5xl font-extrabold text-blue-400 mb-2">1k+</div>
                    <p class="text-slate-400 font-medium">Outfit Dianalisis</p>
                </div>
                <div class="hover:-translate-y-2 transition-transform duration-300">
                    <div class="text-4xl lg:text-5xl font-extrabold text-blue-400 mb-2">98%</div>
                    <p class="text-slate-400 font-medium">Akurasi Match</p>
                </div>
                <div class="hover:-translate-y-2 transition-transform duration-300">
                    <div class="text-4xl lg:text-5xl font-extrabold text-blue-400 mb-2">4.9</div>
                    <p class="text-slate-400 font-medium">User Rating</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-center text-3xl font-bold text-slate-900 mb-12">Kata Mereka yang Sudah Coba</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                    <div class="flex items-center gap-4 mb-4">
                        <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?w=100&h=100&fit=crop" class="w-12 h-12 rounded-full object-cover ring-2 ring-blue-100">
                        <div>
                            <p class="font-bold text-slate-900">Sarah A.</p>
                            <p class="text-xs text-gray-500">Mahasiswa</p>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"Gila sih, ngebantu banget pas mau cari baju buat wisudaan tapi bingung stylenya. Sekali scan langsung nemu kemeja yang pas!"</p>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                    <div class="flex items-center gap-4 mb-4">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop" class="w-12 h-12 rounded-full object-cover ring-2 ring-blue-100">
                        <div>
                            <p class="font-bold text-slate-900">Rizky P.</p>
                            <p class="text-xs text-gray-500">Content Creator</p>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"Sebagai cowok yang buta fashion, ScanFit ini life saver banget. Tinggal foto outfit pinterest, langsung dikasih tau beli dimana."</p>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                    <div class="flex items-center gap-4 mb-4">
                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=100&h=100&fit=crop" class="w-12 h-12 rounded-full object-cover ring-2 ring-blue-100">
                        <div>
                            <p class="font-bold text-slate-900">Dinda K.</p>
                            <p class="text-xs text-gray-500">Karyawan Swasta</p>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"Suka banget sama fitur My Closet-nya. Jadi bisa mix and match baju yang udah aku punya sama rekomendasi baru."</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="group bg-slate-900 rounded-3xl p-12 text-center relative overflow-hidden transition-all duration-500 hover:shadow-2xl">
                <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500 rounded-full blur-3xl opacity-20 -mr-16 -mt-16 group-hover:opacity-30 transition-opacity duration-500"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-purple-500 rounded-full blur-3xl opacity-20 -ml-16 -mb-16 group-hover:opacity-30 transition-opacity duration-500"></div>
                <div class="relative z-10">
                    <span class="text-blue-400 font-bold tracking-widest uppercase text-sm mb-4 block">Untuk Pemilik Brand</span>
                    <h2 class="text-3xl sm:text-4xl font-bold text-white mb-6">Jangkau Ribuan Pelanggan Baru Hari Ini</h2>
                    <p class="text-gray-400 text-lg mb-8 max-w-2xl mx-auto">Tampilkan produkmu di hadapan user yang sedang mencari style spesifik. Tingkatkan konversi penjualan dengan rekomendasi berbasis AI.</p>
                    <a href="/brand/register" class="inline-flex items-center px-8 py-4 bg-white text-slate-900 rounded-full font-bold hover:bg-gray-100 hover:scale-105 transition-all duration-300 shadow-lg">Daftar Sebagai Partner</a>
                </div>
            </div>
        </div>
    </section>

</x-layout>