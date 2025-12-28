<x-layout>
    <style>
        .animate-fade-in-up { animation: fadeInUp 0.8s ease-out forwards; }
        .animation-delay-300 { animation-delay: 0.3s; }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        /* Animasi Floating untuk HP */
        @keyframes float {
            0% { transform: translateY(0px) rotate(-6deg); }
            50% { transform: translateY(-10px) rotate(-6deg); }
            100% { transform: translateY(0px) rotate(-6deg); }
        }
        .animate-float-phone {
            animation: float 6s ease-in-out infinite;
        }
        /* Hide scrollbar but keep functionality */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>

    <div class="min-h-screen bg-slate-50">
        
        <section class="relative overflow-hidden bg-white pt-48 pb-12">
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-50 rounded-full blur-3xl opacity-60 -mr-20 -mt-20"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div class="space-y-6 animate-fade-in-up text-center lg:text-left">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold tracking-wide mb-2 border border-blue-200 w-fit mx-auto lg:mx-0">
                            👋 Welcome back
                        </div>
                        <h1 class="text-4xl lg:text-5xl font-extrabold text-slate-900 leading-tight">
                            Hi, <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">{{ Auth::user()->name }}</span>!
                        </h1>
                        <p class="text-lg text-gray-600 leading-relaxed max-w-xl mx-auto lg:mx-0">
                            Kami sudah memilihkan beberapa outfit <span class="font-semibold text-slate-800">{{ Auth::user()->profile->style_preference ?? 'Casual' }}</span> yang cocok banget buat kamu hari ini.
                        </p>
                        
                        <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start pt-4">
                            <a href="#scan-section" class="group relative inline-flex items-center justify-center px-8 py-3.5 bg-slate-900 text-white rounded-full font-bold shadow-lg shadow-blue-900/20 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                                <span class="relative z-10 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    Mulai Scan
                                </span>
                                <div class="absolute inset-0 h-full w-full scale-0 rounded-full transition-all duration-300 group-hover:scale-100 group-hover:bg-blue-600"></div>
                            </a>
                            <a href="{{ route('explore.index') }}" class="inline-flex items-center justify-center px-8 py-3.5 border-2 border-slate-200 text-slate-700 bg-white rounded-full font-bold hover:border-slate-900 hover:text-slate-900 transition-all duration-300">
                                Eksplorasi Gaya
                            </a>
                        </div>
                    </div>
                    
                    <div class="hidden lg:flex justify-center animate-fade-in-up animation-delay-300">
                        <div class="relative w-72">
                            <img src="{{ asset('images/hero-phone.png') }}" alt="App Mockup" class="w-full relative z-10 drop-shadow-2xl animate-float-phone">
                            
                            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[120%] h-[120%] bg-gradient-to-tr from-blue-100 to-purple-100 rounded-full blur-3xl -z-10 opacity-60"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900">Rekomendasi Untukmu</h2>
                    <p class="text-sm text-gray-500 mt-1">Dipilih khusus berdasarkan preferensi gayamu.</p>
                </div>
                <div class="flex gap-2">
                    <button @click="document.getElementById('rec-scroll').scrollBy({left: -300, behavior: 'smooth'})" class="p-2 rounded-full border border-gray-200 hover:bg-gray-100 hover:border-gray-300 transition bg-white shadow-sm">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    <button @click="document.getElementById('rec-scroll').scrollBy({left: 300, behavior: 'smooth'})" class="p-2 rounded-full border border-gray-200 hover:bg-gray-100 hover:border-gray-300 transition bg-white shadow-sm">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>
            </div>

            <div x-data="{ likedItems: {} }" class="relative group">
                <div class="absolute right-0 top-0 bottom-0 w-24 bg-gradient-to-l from-gray-50/90 to-transparent z-10 pointer-events-none md:hidden"></div>

                <div id="rec-scroll" class="flex gap-6 pb-8 overflow-x-auto scroll-smooth snap-x snap-mandatory no-scrollbar px-1">
                    @foreach($recommendations as $product)
                        <div class="flex-shrink-0 w-72 snap-start">
                            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 h-full flex flex-col overflow-hidden group/card">
                                <div class="relative w-full aspect-[4/5] overflow-hidden bg-gray-100">
                                    <a href="{{ route('products.show', $product) }}">
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover/card:scale-105 transition duration-500">
                                    </a>
                                    
                                    <div class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm text-slate-900 border border-gray-200 rounded-full text-[10px] font-bold px-2.5 py-1 shadow-sm flex items-center gap-1">
                                        <span class="text-green-500">★</span> 98% Match
                                    </div>

                                    <button @click="likedItems[{{$loop->index}}] = !likedItems[{{$loop->index}}]" class="absolute top-3 right-3 w-8 h-8 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-sm hover:bg-white transition active:scale-90">
                                        <svg class="w-5 h-5 transition-colors duration-300" :class="likedItems[{{$loop->index}}] ? 'text-red-500 fill-current' : 'text-gray-400'" viewBox="0 0 24 24" stroke="currentColor" fill="none">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                    </button>
                                </div>

                                <div class="p-4 flex-grow flex flex-col justify-between">
                                    <div>
                                        <p class="text-xs text-gray-500 font-medium mb-1 uppercase tracking-wide">{{ $product->brand->name ?? 'Brand' }}</p>
                                        <a href="{{ route('products.show', $product) }}">
                                            <h3 class="font-bold text-slate-900 text-sm leading-tight line-clamp-2 hover:text-blue-600 transition">{{ $product->name }}</h3>
                                        </a>
                                    </div>
                                    <div class="pt-3 flex justify-between items-end border-t border-gray-50 mt-3">
                                        <span class="text-slate-900 font-extrabold text-base">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </span>
                                        <a href="{{ route('products.show', $product) }}" class="text-blue-600 hover:text-blue-700 text-xs font-bold underline decoration-2 underline-offset-2">
                                            LIHAT
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- BANNER CAROUSEL SECTION --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-xs text-slate-500">Banner tersedia: {{ $banners?->count() ?? 0 }}</p>
        </div>
        @if($banners && $banners->count() > 0)
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="relative">
                <div class="overflow-hidden rounded-3xl shadow-xl group" x-data="carousel">
                    {{-- Banner Carousel --}}
                    <div class="relative w-full aspect-[16/6] md:aspect-[21/9] bg-slate-200">
                        @foreach($banners as $index => $banner)
                        <div class="absolute inset-0 transition-opacity duration-1000" 
                             :class="current === {{ $index }} ? 'opacity-100' : 'opacity-0'">
                            @if($banner->banner_image_url)
                                <img src="{{ asset('storage/' . $banner->banner_image_url) }}" 
                                     alt="{{ $banner->title }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center">
                                    <div class="text-center">
                                        <svg class="w-20 h-20 mx-auto text-white mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-white text-sm font-medium opacity-75">{{ $banner->title }}</p>
                                    </div>
                                </div>
                            @endif
                            
                            {{-- Banner Overlay with CTA --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/70 via-transparent to-transparent flex items-end p-8">
                                <div class="w-full">
                                    <h3 class="text-2xl md:text-3xl font-bold text-white mb-2">{{ $banner->title }}</h3>
                                    @if($banner->description)
                                    <p class="text-white/90 text-sm md:text-base mb-4">{{ $banner->description }}</p>
                                    @endif
                                    @if($banner->link_url)
                                    <a href="{{ $banner->link_url }}" 
                                       onclick="fetch('{{ route('banner.click', $banner) }}')"
                                       class="inline-flex items-center px-6 py-2.5 bg-white text-slate-900 rounded-lg font-bold hover:bg-slate-100 transition">
                                        {{ $banner->cta_text ?? 'Lihat Selengkapnya' }}
                                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach

                        {{-- Auto-play Timer --}}
                        <script>
                        document.addEventListener('alpine:init', () => {
                            Alpine.data('carousel', () => ({
                                current: 0,
                                banners: {{ count($banners) }},
                                autoPlay: true,
                                init() {
                                    if (this.autoPlay && this.banners > 1) {
                                        setInterval(() => {
                                            this.current = (this.current + 1) % this.banners;
                                        }, 5000);
                                    }
                                },
                                next() {
                                    this.current = (this.current + 1) % this.banners;
                                },
                                prev() {
                                    this.current = (this.current - 1 + this.banners) % this.banners;
                                }
                            }));
                        });
                        </script>
                    </div>

                    {{-- Navigation Buttons --}}
                    @if($banners->count() > 1)
                    <button @click="prev()" class="absolute left-4 top-1/2 -translate-y-1/2 z-10 w-10 h-10 bg-white/80 hover:bg-white text-slate-900 rounded-full flex items-center justify-center transition-all shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <button @click="next()" class="absolute right-4 top-1/2 -translate-y-1/2 z-10 w-10 h-10 bg-white/80 hover:bg-white text-slate-900 rounded-full flex items-center justify-center transition-all shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>

                    {{-- Indicators --}}
                    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 z-10 flex gap-2">
                        @for($i = 0; $i < $banners->count(); $i++)
                        <button @click="current = {{ $i }}" 
                                :class="current === {{ $i }} ? 'w-8 bg-white' : 'w-2 bg-white/50'"
                                class="h-2 rounded-full transition-all duration-300">
                        </button>
                        @endfor
                    </div>
                    @endif
                </div>
            </div>
        </section>
        {{-- Fallback static banners grid (non-JS) --}}
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($banners as $banner)
                    <div class="relative rounded-2xl overflow-hidden border border-slate-200 shadow-sm">
                        @if($banner->banner_image_url)
                            <img src="{{ asset('storage/' . $banner->banner_image_url) }}" alt="{{ $banner->title }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gradient-to-r from-blue-500 to-purple-500"></div>
                        @endif
                        <div class="p-4">
                            <h3 class="text-base font-bold text-slate-900">{{ $banner->title }}</h3>
                            @if($banner->description)
                                <p class="text-sm text-slate-600 mt-1">{{ Str::limit($banner->description, 100) }}</p>
                            @endif
                            @if($banner->link_url)
                                <a href="{{ $banner->link_url }}" onclick="fetch('{{ route('banner.click', $banner) }}')" class="inline-flex items-center mt-3 px-4 py-2 bg-slate-900 text-white rounded-lg text-sm font-bold hover:bg-slate-800">
                                    {{ $banner->cta_text ?? 'Lihat Selengkapnya' }}
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
        @endif

        <section id="scan-section" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="relative w-full rounded-3xl overflow-hidden shadow-2xl group">
                <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-105" 
                     style="background-image: url('https://images.unsplash.com/photo-1490481651871-ab68de25d43d?q=80&w=2070&auto=format&fit=crop')">
                </div>
                
                <div class="absolute inset-0 bg-gradient-to-r from-slate-900/90 via-slate-900/60 to-transparent"></div>

                <div class="relative z-10 px-8 py-16 md:p-20 max-w-2xl">
                    <span class="inline-block py-1 px-3 rounded-lg bg-white/20 backdrop-blur-md text-white text-xs font-bold tracking-widest uppercase mb-4 border border-white/30">
                        AI Technology
                    </span>
                    <h3 class="text-3xl md:text-5xl font-extrabold text-white mb-6 leading-tight">
                        Temukan Outfit Impian <br>Dalam Sekejap
                    </h3>
                    <p class="text-slate-300 text-lg mb-8 max-w-md">
                        Upload foto OOTD inspirasimu, biarkan AI kami mencarikan produk serupa dari ratusan brand lokal.
                    </p>
                    <a href="{{ route('scan.index') }}" class="inline-flex items-center gap-3 bg-white text-slate-900 px-8 py-4 rounded-full font-bold hover:bg-blue-50 transition-all shadow-lg hover:shadow-white/20 group/btn">
                        <svg class="w-5 h-5 text-slate-900 group-hover/btn:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Mulai Scan Sekarang
                    </a>
                </div>
            </div>
        </section>

        <section x-data="{ activeCategory: 'Semua' }" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                <h2 class="text-2xl font-bold text-slate-900">Explore Style</h2>
                
                <div class="flex gap-3 overflow-x-auto pb-2 no-scrollbar">
                    @foreach([
                        ['label' => 'Semua', 'icon' => 'M4 6h16M4 12h16M4 18h16'], 
                        ['label' => 'Atasan', 'icon' => 'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4z'], 
                        ['label' => 'Bawahan', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                        ['label' => 'Outerwear', 'icon' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z'],
                        ['label' => 'Aksesoris', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z']
                    ] as $cat)
                        <button @click="activeCategory = '{{ $cat['label'] }}'" 
                                :class="activeCategory === '{{ $cat['label'] }}' ? 'bg-slate-900 text-white shadow-md' : 'bg-white text-slate-600 border border-gray-200 hover:bg-gray-50'" 
                                class="flex items-center gap-2 px-5 py-2.5 rounded-full font-medium text-sm transition-all whitespace-nowrap">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $cat['icon'] }}"></path></svg>
                            {{ $cat['label'] }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                @foreach($exploreProducts as $product)
                    <div x-show="activeCategory === 'Semua' || activeCategory === '{{ $product->category }}'" 
                         x-transition.opacity.duration.300ms
                         class="group bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col overflow-hidden">
                        
                        <div class="relative aspect-square bg-gray-100 overflow-hidden">
                            <a href="{{ route('products.show', $product) }}">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            </a>
                            
                            <div class="absolute inset-x-0 bottom-0 p-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300 hidden md:block">
                                <button onclick="saveToClosetHome({{ $product->id }})" class="w-full bg-white/95 backdrop-blur shadow-lg text-slate-900 font-bold py-2 rounded-lg text-xs hover:bg-blue-600 hover:text-white transition-colors">
                                    + Add to Closet
                                </button>
                            </div>
                            <button onclick="saveToClosetHome({{ $product->id }})" class="md:hidden absolute bottom-2 right-2 w-8 h-8 bg-white/90 rounded-full shadow-md flex items-center justify-center text-slate-900">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            </button>
                        </div>

                        <div class="p-3 md:p-4 flex flex-col flex-grow">
                            <p class="text-[10px] md:text-xs text-gray-500 font-semibold uppercase mb-1">{{ $product->brand->name ?? 'Brand' }}</p>
                            <a href="{{ route('products.show', $product) }}" class="flex-grow">
                                <h3 class="text-sm font-bold text-slate-900 line-clamp-2 leading-snug mb-2 group-hover:text-blue-600 transition">{{ $product->name }}</h3>
                            </a>
                            <p class="text-sm font-extrabold text-slate-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="bg-slate-900 rounded-3xl p-8 md:p-12 relative overflow-hidden">
                <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
                <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500 rounded-full blur-3xl opacity-20 -mr-16 -mt-16"></div>

                <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
                    <div class="text-center md:text-left">
                        <h2 class="text-2xl md:text-3xl font-bold text-white mb-2">Komunitas Fashion</h2>
                        <p class="text-slate-400">Lihat apa yang sedang hits dan dipakai oleh fashionista lainnya.</p>
                    </div>
                    
                    <div class="flex items-center gap-4 bg-white/10 backdrop-blur-md p-4 rounded-2xl border border-white/10">
                        <div class="flex -space-x-3">
                            <img class="w-10 h-10 rounded-full border-2 border-slate-800" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&h=100&fit=crop" alt="User">
                            <img class="w-10 h-10 rounded-full border-2 border-slate-800" src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=100&h=100&fit=crop" alt="User">
                            <img class="w-10 h-10 rounded-full border-2 border-slate-800" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop" alt="User">
                            <div class="w-10 h-10 rounded-full border-2 border-slate-800 bg-blue-600 flex items-center justify-center text-xs font-bold text-white">+2k</div>
                        </div>
                        <div class="h-8 w-px bg-white/20"></div>
                        <a href="{{ route('explore.index') }}" class="text-sm font-bold text-white hover:text-blue-300 transition flex items-center gap-1">
                            Gabung
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <div class="h-20"></div>
    </div>

    <script>
        async function saveToClosetHome(itemId) {
            // ... (Script logika simpan ke closet yang sudah ada)
            // Biarkan script lama, hanya pastikan tombolnya memanggil fungsi ini
            try {
                const btn = event.target.closest('button'); // Ensure we target the button even if icon clicked
                const originalContent = btn.innerHTML;
                
                // Visual feedback loading
                btn.innerHTML = '<svg class="animate-spin h-4 w-4" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
                
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
                    btn.classList.remove('bg-white', 'text-brand-dark');
                    btn.classList.add('bg-green-500', 'text-white');
                    btn.innerHTML = '✔';
                    setTimeout(() => {
                        btn.innerHTML = originalContent;
                        btn.classList.remove('bg-green-500', 'text-white');
                        btn.classList.add('bg-white', 'text-brand-dark');
                    }, 2000);
                } else if (response.status === 401) {
                    window.location.href = '/login';
                } else {
                    alert(data.message || 'Gagal menyimpan.');
                    btn.innerHTML = originalContent;
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan.');
            }
        }
    </script>
</x-layout>