<x-layout>
    <x-slot:title>{{ $item->name }}</x-slot:title>

    <div class="min-h-screen bg-white pt-48 pb-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

                    <!-- Left Column: Product Images -->
                    <div x-data="{ activeImage: '{{ $item->image_url }}' }" class="space-y-4">
                        <!-- Main Image -->
                        <div class="aspect-square rounded-2xl overflow-hidden bg-slate-100">
                            <img :src="activeImage" alt="{{ $item->name }}" class="w-full h-full object-cover">
                        </div>

                        <!-- Thumbnails -->
                        <div class="flex space-x-2 overflow-x-auto">
                            <button @click="activeImage = '{{ $item->image_url }}'" class="flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden border-2 border-slate-300 hover:border-slate-900 transition-colors">
                                <img src="{{ $item->image_url }}" alt="Thumbnail 1" class="w-full h-full object-cover">
                            </button>
                            <!-- Add more thumbnails if available, e.g., $item->additional_images -->
                            @if(isset($item->additional_images) && is_array($item->additional_images))
                                @foreach($item->additional_images as $thumb)
                                    <button @click="activeImage = '{{ $thumb }}'" class="flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden border-2 border-slate-300 hover:border-slate-900 transition-colors">
                                        <img src="{{ $thumb }}" alt="Thumbnail" class="w-full h-full object-cover">
                                    </button>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <!-- Right Column: Product Details -->
                    <div x-data="{ selectedColor: null, selectedSize: null, colorMap: { 'navy': '#000080', 'maroon': '#800000', 'black': '#000000', 'white': '#FFFFFF', 'red': '#FF0000', 'blue': '#0000FF', 'green': '#008000', 'yellow': '#FFFF00', 'purple': '#800080', 'pink': '#FFC0CB', 'gray': '#808080', 'brown': '#A52A2A' } }" class="space-y-6">
                        <!-- Breadcrumbs -->
                        <nav class="text-sm text-slate-500">
                            <a href="/" class="hover:text-slate-700">Home</a> &gt;
                            <a href="{{ route('explore.index') }}" class="hover:text-slate-700">Explore</a> &gt;
                            <span class="text-slate-900">{{ $item->name }}</span>
                        </nav>

                        <!-- Brand Header -->
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-200">
                                <img src="{{ $item->brand->logo_url ?? 'https://via.placeholder.com/48' }}" alt="{{ $item->brand->name ?? 'Brand' }}" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-slate-900">{{ $item->brand->name ?? 'Brand' }}</h2>
                                <a href="{{ route('brand.show', $item->brand->id ?? '#') }}" class="text-sm text-blue-600 hover:text-blue-800">Visit Store</a>
                            </div>
                        </div>

                        <!-- Product Title -->
                        <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 leading-tight">{{ $item->name }}</h1>

                        <!-- Style Badge -->
                        <div class="flex items-center space-x-4">
                            <span class="inline-block bg-slate-800 text-white font-bold uppercase tracking-wide px-4 py-2 rounded-full text-sm">
                                {{ $item->category ?? 'Style' }}
                            </span>
                        </div>

                        <!-- Price -->
                        <div>
                            <p class="text-3xl font-extrabold text-slate-900">
                                Rp {{ number_format($item->price, 0, ',', '.') }}
                            </p>
                            @if($item->original_price && $item->original_price > $item->price)
                                <p class="text-lg text-slate-400 line-through font-medium mt-1">
                                    Rp {{ number_format($item->original_price, 0, ',', '.') }}
                                </p>
                            @endif
                        </div>

                        <!-- Description -->
                        <div>
                            <p class="text-base text-slate-600 leading-relaxed">
                                {{ $item->description ?? 'Produk fashion berkualitas tinggi dari brand terpercaya. Temukan gaya yang sesuai dengan kepribadian Anda.' }}
                            </p>
                        </div>

                        <!-- Size Selector -->
                        @if($item->sizes && is_array($item->sizes))
                            <div>
                                <h3 class="text-base font-bold text-slate-900 mb-3">Ukuran</h3>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($item->sizes as $size)
                                        <button @click="selectedSize = '{{ $size }}'" 
                                                :class="selectedSize === '{{ $size }}' ? 'border-slate-900 bg-slate-900 text-white' : 'border-slate-300 bg-white text-slate-700 hover:border-slate-900'"
                                                class="px-4 py-2 border-2 rounded-lg font-medium transition-colors">
                                            {{ $size }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Color Selector -->
                        @if($item->colors && is_array($item->colors))
                            <div>
                                <h3 class="text-base font-bold text-slate-900 mb-3">Warna</h3>
                                <div class="flex flex-wrap gap-3">
                                    @foreach($item->colors as $color)
                                        <button @click="selectedColor = '{{ $color }}'" 
                                                :class="selectedColor === '{{ $color }}' ? 'ring-2 ring-slate-900 ring-offset-2' : ''"
                                                class="w-10 h-10 rounded-full border-2 border-slate-300 hover:border-slate-900 transition-all"
                                                style="background-color: {{ strtolower($color) === 'navy' ? '#001f3f' : (strtolower($color) === 'maroon' ? '#800000' : $color) }};">
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="space-y-4">
                            @if($item->link_shopee || $item->link_tokopedia)
                                <div class="flex flex-col sm:flex-row gap-3">
                                    @if($item->link_shopee)
                                        <button onclick="trackAndOpen('{{ $item->link_shopee }}', 'shopee')" 
                                                class="flex-1 text-white font-bold py-3 px-4 rounded-lg transition-colors shadow-md hover:shadow-lg flex items-center justify-center"
                                                style="background-color: #EE4D2D;">
                                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                            </svg>
                                            Shopee
                                        </button>
                                    @else
                                        <div class="flex-1 bg-gray-300 text-gray-500 font-bold py-3 px-4 rounded-lg text-center">
                                            Stok Habis
                                        </div>
                                    @endif
                                    @if($item->link_tokopedia)
                                        <button onclick="trackAndOpen('{{ $item->link_tokopedia }}', 'tokopedia')" 
                                                class="flex-1 text-white font-bold py-3 px-4 rounded-lg transition-colors shadow-md hover:shadow-lg flex items-center justify-center"
                                                style="background-color: #03AC0E;">
                                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                            </svg>
                                            Tokopedia
                                        </button>
                                    @else
                                        <div class="flex-1 bg-gray-300 text-gray-500 font-bold py-3 px-4 rounded-lg text-center">
                                            Stok Habis
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <p class="text-slate-600 mb-2">Link marketplace akan segera tersedia</p>
                                    <p class="text-sm text-slate-500">Hubungi brand untuk informasi pembelian</p>
                                </div>
                            @endif

                            @auth
                                <button id="saveButton" onclick="saveToCloset({{ $item->id }})" 
                                    class="w-full font-bold py-3 px-4 rounded-lg transition-colors flex items-center justify-center
                                    {{ $isSaved ? 'bg-emerald-600 hover:bg-emerald-700' : 'bg-slate-900 hover:bg-slate-800' }} text-white">
                                    <svg id="saveIcon" class="w-5 h-5 mr-2" fill="{{ $isSaved ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                    <span id="saveText">{{ $isSaved ? 'Tersimpan di Closet' : 'Simpan ke Closet' }}</span>
                                </button>
                            @else
                                <p class="text-sm text-gray-600 text-center">
                                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800">Login</a> untuk menyimpan ke closet
                                </p>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recommendations Section -->
    @if($moreFromBrand->count() > 0)
        <div class="py-16 bg-slate-50 border-t border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-xl font-bold text-slate-900">Lainnya dari {{ $item->brand->name }}</h2>
                    <a href="{{ route('brand.show', $item->brand) }}" class="text-blue-600 hover:text-blue-800 font-medium text-base">Lihat Semua &rarr;</a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($moreFromBrand as $product)
                        <a href="{{ route('products.show', $product) }}" class="group bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 flex flex-col h-full overflow-hidden">
                            <div class="relative aspect-[4/5] overflow-hidden bg-slate-100 rounded-lg">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute top-2 left-2 w-8 h-8 rounded-full overflow-hidden bg-white border border-slate-200">
                                    <img src="{{ $product->brand->logo_url ?? 'https://via.placeholder.com/32' }}" alt="{{ $product->brand->name }}" class="w-full h-full object-cover">
                                </div>
                            </div>
                            <div class="p-4">
                                <p class="text-xs font-bold uppercase tracking-wide text-slate-500">{{ $product->brand->name }}</p>
                                <h3 class="text-slate-900 font-bold text-base leading-tight line-clamp-1 mb-2 group-hover:text-blue-800 transition-colors">
                                    {{ $product->name }}
                                </h3>
                                <p class="text-lg font-extrabold text-slate-900">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    @if($similarStyles->count() > 0)
        <div class="py-16 bg-slate-50 border-t border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-xl font-bold text-slate-900">Mungkin Kamu Juga Suka</h2>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($similarStyles as $product)
                        <a href="{{ route('products.show', $product) }}" class="group bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 flex flex-col h-full overflow-hidden">
                            <div class="relative aspect-[4/5] overflow-hidden bg-slate-100 rounded-lg">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute top-2 left-2 w-8 h-8 rounded-full overflow-hidden bg-white border border-slate-200">
                                    <img src="{{ $product->brand->logo_url ?? 'https://via.placeholder.com/32' }}" alt="{{ $product->brand->name }}" class="w-full h-full object-cover">
                                </div>
                            </div>
                            <div class="p-4">
                                <p class="text-xs font-bold uppercase tracking-wide text-slate-500">{{ $product->brand->name }}</p>
                                <h3 class="text-slate-900 font-bold text-base leading-tight line-clamp-1 mb-2 group-hover:text-blue-800 transition-colors">
                                    {{ $product->name }}
                                </h3>
                                <p class="text-lg font-extrabold text-slate-900">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Success Modal -->
    <div id="successModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-6 pt-8 pb-6">
                    <div class="flex flex-col items-center">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-16 w-16 rounded-full bg-emerald-100 mb-4">
                            <svg class="h-8 w-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div class="text-center">
                            <h3 class="text-xl font-bold text-gray-900 mb-2" id="modal-title">Berhasil Disimpan!</h3>
                            <p class="text-sm text-gray-600 mb-6" id="modalMessage">Item telah ditambahkan ke closet Anda.</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('closet.index') }}" class="flex-1 inline-flex justify-center items-center px-4 py-2.5 border border-transparent text-sm font-bold rounded-lg text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        Lihat Closet
                    </a>
                    <button type="button" onclick="closeModal()" class="flex-1 inline-flex justify-center items-center px-4 py-2.5 border border-gray-300 text-sm font-bold rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        let isSaved = {{ $isSaved ? 'true' : 'false' }};

        function showModal(message) {
            document.getElementById('modalMessage').textContent = message;
            document.getElementById('successModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('successModal').classList.add('hidden');
        }

        function updateSaveButton(saved) {
            const button = document.getElementById('saveButton');
            const icon = document.getElementById('saveIcon');
            const text = document.getElementById('saveText');
            
            if (saved) {
                button.className = 'w-full font-bold py-3 px-4 rounded-lg transition-colors flex items-center justify-center bg-emerald-600 hover:bg-emerald-700 text-white';
                icon.setAttribute('fill', 'currentColor');
                text.textContent = 'Tersimpan di Closet';
            } else {
                button.className = 'w-full font-bold py-3 px-4 rounded-lg transition-colors flex items-center justify-center bg-slate-900 hover:bg-slate-800 text-white';
                icon.setAttribute('fill', 'none');
                text.textContent = 'Simpan ke Closet';
            }
        }

        async function saveToCloset(itemId) {
            if (isSaved) {
                showModal('Item ini sudah ada di closet Anda!');
                return;
            }

            try {
                const response = await fetch('/closet/save', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ item_id: itemId })
                });

                const data = await response.json();

                if (response.ok) {
                    isSaved = true;
                    updateSaveButton(true);
                    showModal(data.message || 'Item berhasil disimpan ke closet!');
                } else if (response.status === 401) {
                    alert('Anda harus login terlebih dahulu!');
                    window.location.href = '/login';
                } else if (response.status === 409) {
                    isSaved = true;
                    updateSaveButton(true);
                    showModal(data.message || 'Item sudah ada di closet!');
                } else {
                    showModal(data.message || 'Gagal menyimpan item. Silakan coba lagi.');
                }
            } catch (error) {
                console.error('Error:', error);
                showModal('Terjadi kesalahan. Silakan coba lagi.');
            }
        }

        async function trackAndOpen(url, platform) {
            try {
                const response = await fetch('/track-click/{{ $item->id }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                if (response.ok) {
                    window.open(url, '_blank');
                } else {
                    // Open anyway even if tracking fails
                    window.open(url, '_blank');
                }
            } catch (error) {
                // Open anyway even if error occurs
                window.open(url, '_blank');
            }
        }
    </script>
</x-layout>