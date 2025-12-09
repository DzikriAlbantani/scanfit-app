<x-layout>
    <div class="min-h-screen bg-gradient-to-b from-brand-bg/40 to-white">
        <!-- HERO SECTION -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                <!-- Kiri: Sapaan & Subtext -->
                <div class="space-y-4">
                    <h1 class="text-4xl lg:text-5xl font-extrabold text-brand-dark">
                        Hi, {{ Auth::user()->name }}!
                    </h1>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        Berdasarkan gayamu (Streetwear & Casual), ini outfit yang mungkin kamu suka.
                    </p>
                </div>

                <!-- Kanan: Gambar Mockup HP (Floating) -->
                <div class="hidden lg:flex justify-center">
                    <div class="flex justify-center md:justify-end">
                        <img src="{{ asset('images/hero-phone.png') }}" alt="App Mockup" class="w-full max-w-sm mx-auto -rotate-6 hover:rotate-0 transition-transform duration-500 drop-shadow-lg">
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION 1: REKOMENDASI UNTUKMU -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h2 class="text-3xl font-bold text-brand-dark mb-8">
                Rekomendasi Untukmu
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($recommendations as $product)
                    <div class="group relative bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition duration-300">
                        <!-- Gambar Produk -->
                        <div class="relative w-full aspect-square overflow-hidden bg-gray-100">
                            <img src="{{ $product->image_url }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            
                            <!-- Badge 98% Match -->
                            <div class="absolute top-3 left-3 bg-brand-dark text-white rounded-full text-xs font-semibold px-3 py-1">
                                98% match
                            </div>
                        </div>

                        <!-- Info Produk -->
                        <div class="p-4 space-y-3">
                            <h3 class="font-semibold text-gray-900 text-sm line-clamp-2">
                                {{ $product->name }}
                            </h3>
                            <div class="flex justify-between items-center">
                                <span class="text-brand-dark font-bold text-sm">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                                <button class="text-red-400 hover:text-red-600 transition">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- SECTION 2: SCAN OUTFIT KAMU (Banner Besar) -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="relative w-full h-72 rounded-2xl overflow-hidden bg-cover bg-center" 
                 style="background-image: url('https://images.unsplash.com/photo-1489749798305-4fea3ba63d60?q=80&w=1200&auto=format&fit=crop')">
                
                <!-- Overlay Gelap -->
                <div class="absolute inset-0 bg-black/40"></div>

                <!-- Konten -->
                <div class="absolute inset-0 flex flex-col items-center justify-center space-y-6">
                    <h3 class="text-4xl font-bold text-white text-center">
                        Scan Outfit Kamu
                    </h3>
                    <button class="border-2 border-white text-white px-8 py-3 rounded-full font-semibold hover:bg-white hover:text-brand-dark transition duration-300 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Mulai Scan
                    </button>
                </div>
            </div>
        </section>

        <!-- SECTION 3: EXPLORE LIKE YOURS (Product Grid) -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h2 class="text-3xl font-bold text-brand-dark mb-8">
                Explore Like Yours
            </h2>

            <!-- Filter Pills -->
            <div class="flex flex-wrap gap-3 mb-8">
                <button class="px-6 py-2 bg-brand-dark text-white rounded-full font-medium text-sm hover:bg-brand-dark/80 transition">
                    Semua
                </button>
                <button class="px-6 py-2 border-2 border-gray-300 text-gray-700 rounded-full font-medium text-sm hover:border-brand-dark hover:text-brand-dark transition">
                    Atasan
                </button>
                <button class="px-6 py-2 border-2 border-gray-300 text-gray-700 rounded-full font-medium text-sm hover:border-brand-dark hover:text-brand-dark transition">
                    Bawahan
                </button>
                <button class="px-6 py-2 border-2 border-gray-300 text-gray-700 rounded-full font-medium text-sm hover:border-brand-dark hover:text-brand-dark transition">
                    Sepatu
                </button>
            </div>

            <!-- Grid Produk -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($exploreProducts as $product)
                    <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition duration-300">
                        <!-- Gambar -->
                        <div class="relative w-full aspect-square overflow-hidden bg-gray-100">
                            <img src="{{ $product->image_url }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover hover:scale-105 transition duration-300">
                        </div>

                        <!-- Info -->
                        <div class="p-4 space-y-3">
                            <h3 class="font-semibold text-gray-900 text-sm line-clamp-2">
                                {{ $product->name }}
                            </h3>
                            <p class="text-gray-500 text-xs">
                                {{ $product->category }}
                            </p>
                            <p class="text-brand-dark font-bold text-sm">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p>
                            <button class="w-full border-2 border-brand-dark text-brand-dark px-4 py-2 rounded-lg font-medium text-sm hover:bg-brand-dark hover:text-white transition duration-300">
                                Coba Gaya Ini
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- SECTION 4: PROMO & TREN MARKETPLACE -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h2 class="text-3xl font-bold text-brand-dark mb-8">
                Promo & Tren Marketplace
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @php
                    $promoLabels = ['Flash Sale', 'New Arrivals', 'Best Sellers'];
                @endphp

                @foreach($promoProducts as $index => $product)
                    <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition duration-300 flex flex-col sm:flex-row">
                        <!-- Gambar Kiri -->
                        <div class="w-full sm:w-40 aspect-square sm:aspect-auto flex-shrink-0 bg-gray-100">
                            <img src="{{ $product->image_url }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover">
                        </div>

                        <!-- Info Kanan -->
                        <div class="p-4 flex flex-col justify-between flex-grow">
                            <div class="space-y-2">
                                <div class="inline-block bg-brand-dark text-white text-xs font-bold px-3 py-1 rounded">
                                    {{ $promoLabels[$index] ?? 'Promo' }}
                                </div>
                                <h3 class="font-bold text-gray-900 line-clamp-2">
                                    {{ $product->name }}
                                </h3>
                                <p class="text-brand-dark font-bold text-lg">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </p>
                            </div>
                            <button class="mt-3 w-full bg-brand-dark text-white px-4 py-2 rounded-lg font-medium text-sm hover:bg-brand-dark/80 transition">
                                Lihat Produk
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Spacing Bottom -->
        <div class="h-20"></div>
    </div>
</x-layout>
