<x-brand-layout>
    <x-slot:title>Add Product - ScanFit</x-slot:title>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <div class="mb-10">
            <h1 class="text-3xl font-bold text-slate-900">Tambah Produk Baru</h1>
            <p class="text-base text-slate-600 mt-2">Pilih metode untuk menambahkan produk ke katalog Anda</p>
        </div>

        {{-- Tab Navigation --}}
        <div class="flex gap-4 mb-8 border-b border-slate-200">
            <button onclick="switchTab('single')" id="singleTabBtn" class="px-6 py-3 border-b-2 border-blue-600 text-blue-600 font-medium transition-all hover:text-blue-700">
                <svg class="w-5 h-5 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Single Produk
            </button>
            <button onclick="switchTab('bulk')" id="bulkTabBtn" class="px-6 py-3 border-b-2 border-transparent text-slate-600 font-medium transition-all hover:text-slate-700 hover:border-slate-300">
                <svg class="w-5 h-5 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Bulk Import (CSV)
            </button>
        </div>

        {{-- SINGLE PRODUCT FORM TAB --}}
        <div id="singleTabContent">
            <form action="{{ route('brand.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-10">
                    
                    {{-- LEFT COLUMN --}}
                    <div class="lg:col-span-2 space-y-8">
                        
                        {{-- PRODUCT DETAILS --}}
                        <div class="bg-white shadow-sm rounded-xl border border-slate-200 overflow-hidden">
                            <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                                <h3 class="text-lg font-semibold text-slate-900">Detail Produk</h3>
                            </div>
                            <div class="p-6 md:p-8 space-y-6">
                                <div>
                                    <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Nama Produk <span class="text-red-500">*</span></label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="contoh: Oversized Cotton T-Shirt"
                                           class="block w-full border border-slate-300 rounded-lg shadow-sm py-3 px-4 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('name') border-red-300 @enderror" required>
                                    @error('name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="description" class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi</label>
                                    <textarea name="description" id="description" rows="5" placeholder="Jelaskan material, ukuran, gaya, dan tips perawatan..."
                                              class="block w-full border border-slate-300 rounded-lg shadow-sm py-3 px-4 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('description') border-red-300 @enderror">{{ old('description') }}</textarea>
                                    @error('description') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        {{-- PRODUCT IMAGE --}}
                        <div class="bg-white shadow-sm rounded-xl border border-slate-200 overflow-hidden" x-data="imageViewer()">
                            <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                                <h3 class="text-lg font-semibold text-slate-900">Foto Produk</h3>
                            </div>
                            <div class="p-6 md:p-8">
                                <label class="block text-sm font-semibold text-slate-700 mb-4">Foto Utama <span class="text-red-500">*</span></label>
                                
                                <div class="w-full">
                                    <div x-show="!imageUrl" class="mt-2 flex justify-center px-6 pt-10 pb-10 border-2 border-slate-300 border-dashed rounded-xl hover:bg-slate-50 transition-colors group cursor-pointer" @click="$refs.fileInput.click()">
                                        <div class="space-y-2 text-center">
                                            <div class="mx-auto h-16 w-16 text-slate-400 group-hover:text-blue-500 transition-colors">
                                                <svg class="h-full w-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                            <div class="text-sm text-slate-600">
                                                <span class="font-bold text-blue-600 hover:text-blue-500">Klik untuk upload</span>
                                                <span class="pl-1">atau drag and drop</span>
                                            </div>
                                            <p class="text-xs text-slate-500">PNG, JPG, GIF hingga 10MB</p>
                                        </div>
                                    </div>

                                    <div x-show="imageUrl" class="mt-2 relative rounded-xl overflow-hidden border border-slate-200 bg-slate-100" style="display: none;">
                                        <img :src="imageUrl" class="w-full h-64 object-contain">
                                        <button type="button" @click="removeImage" class="absolute top-2 right-2 bg-red-600 text-white p-2 rounded-full hover:bg-red-700 shadow-md transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </div>

                                    <input x-ref="fileInput" id="image" name="image" type="file" accept="image/*" class="sr-only" @change="fileChosen">
                                </div>

                                @error('image') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        {{-- VARIANTS --}}
                        <div class="bg-white shadow-sm rounded-xl border border-slate-200 overflow-hidden">
                            <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                                <h3 class="text-lg font-semibold text-slate-900">Variants & Pilihan</h3>
                            </div>
                            <div class="p-6 md:p-8 space-y-8">
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-3">Ukuran Tersedia</label>
                                    <div class="flex flex-wrap gap-3">
                                        @foreach(['XS', 'S', 'M', 'L', 'XL', 'XXL'] as $size)
                                            <div class="relative">
                                                <input type="checkbox" name="sizes[]" id="size_{{ $size }}" value="{{ $size }}" 
                                                       class="peer sr-only" {{ in_array($size, old('sizes', [])) ? 'checked' : '' }}>
                                                <label for="size_{{ $size }}" 
                                                       class="flex items-center justify-center w-12 h-10 border border-slate-300 rounded-lg text-sm font-medium text-slate-700 cursor-pointer bg-white transition-all hover:bg-slate-50 peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600">
                                                    {{ $size }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('sizes') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <hr class="border-slate-100">

                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-3">Warna Tersedia</label>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3">
                                        @foreach(['Black', 'White', 'Red', 'Blue', 'Green', 'Yellow', 'Purple', 'Pink', 'Gray', 'Brown'] as $color)
                                            <div class="relative flex items-center p-2 rounded-lg hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-200">
                                                <input type="checkbox" name="colors[]" id="color_{{ $color }}" value="{{ $color }}" 
                                                       class="h-4 w-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500 cursor-pointer" {{ in_array($color, old('colors', [])) ? 'checked' : '' }}>
                                                <label for="color_{{ $color }}" class="ml-3 text-sm font-medium text-slate-700 cursor-pointer select-none">{{ $color }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('colors') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        {{-- MARKETPLACE LINKS --}}
                        <div class="bg-white shadow-sm rounded-xl border border-slate-200 overflow-hidden">
                            <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                                <h3 class="text-lg font-semibold text-slate-900">Link Marketplace</h3>
                            </div>
                            <div class="p-6 md:p-8 space-y-6">
                                @foreach(['shopee' => 'Shopee', 'tokopedia' => 'Tokopedia', 'lazada' => 'Lazada'] as $key => $label)
                                <div>
                                    <label for="{{ $key }}_url" class="block text-sm font-semibold text-slate-700 mb-2">{{ $label }}</label>
                                    <input type="url" name="link_{{ $key }}" id="{{ $key }}_url" value="{{ old('link_'.$key) }}"
                                           placeholder="https://www.{{ strtolower($label) }}.co.id/product..."
                                           class="block w-full border border-slate-300 rounded-lg shadow-sm py-3 px-4 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- ACTIONS --}}
                        <div class="flex items-center justify-end space-x-4 pt-4 pb-8 lg:pb-0">
                            <a href="{{ route('brand.products.index') }}"
                               class="px-6 py-3 border border-slate-300 shadow-sm text-base font-medium rounded-lg text-slate-700 bg-white hover:bg-slate-50 transition-all">
                               Batal
                            </a>
                            <button type="submit"
                                    class="inline-flex items-center px-8 py-3 border border-transparent shadow-sm text-base font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Buat Produk
                            </button>
                        </div>

                    </div>

                    {{-- RIGHT COLUMN --}}
                    <div class="space-y-8">
                        
                        {{-- PRICING --}}
                        <div class="bg-white shadow-sm rounded-xl border border-slate-200 overflow-hidden">
                            <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                                <h3 class="text-lg font-semibold text-slate-900">Harga</h3>
                            </div>
                            <div class="p-6 space-y-6">
                                <div>
                                    <label for="price" class="block text-sm font-semibold text-slate-700 mb-2">Harga Jual <span class="text-red-500">*</span></label>
                                    <div class="flex rounded-lg shadow-sm">
                                        <span class="inline-flex items-center px-4 rounded-l-lg border border-r-0 border-slate-300 bg-slate-100 text-slate-500 text-sm font-bold">
                                            Rp
                                        </span>
                                        <input type="number" name="price" id="price" value="{{ old('price') }}" min="0" step="1000"
                                               class="flex-1 focus:ring-blue-500 focus:border-blue-500 block w-full min-w-0 rounded-none rounded-r-lg border border-slate-300 sm:text-sm py-3" placeholder="0" required>
                                    </div>
                                    @error('price') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="original_price" class="block text-sm font-semibold text-slate-700 mb-2">Harga Original</label>
                                    <div class="flex rounded-lg shadow-sm">
                                        <span class="inline-flex items-center px-4 rounded-l-lg border border-r-0 border-slate-300 bg-slate-100 text-slate-500 text-sm font-bold">
                                            Rp
                                        </span>
                                        <input type="number" name="original_price" id="original_price" value="{{ old('original_price') }}" min="0" step="1000"
                                               class="flex-1 focus:ring-blue-500 focus:border-blue-500 block w-full min-w-0 rounded-none rounded-r-lg border border-slate-300 sm:text-sm py-3" placeholder="0">
                                    </div>
                                    <p class="mt-2 text-xs text-slate-500">Isi jika ingin tampil harga diskon (strikethrough)</p>
                                </div>

                                <div class="pt-4 border-t border-slate-100">
                                    <label for="stock" class="block text-sm font-semibold text-slate-700 mb-2">Stok</label>
                                    <input type="number" name="stock" id="stock" value="{{ old('stock', 0) }}" min="0"
                                           class="block w-full border border-slate-300 rounded-lg shadow-sm py-3 px-4 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>
                            </div>
                        </div>

                        {{-- ORGANIZATION --}}
                        <div class="bg-white shadow-sm rounded-xl border border-slate-200 overflow-hidden">
                            <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                                <h3 class="text-lg font-semibold text-slate-900">Organisasi</h3>
                            </div>
                            <div class="p-6 space-y-5">
                                <div>
                                    <label for="category" class="block text-sm font-semibold text-slate-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                                    <select name="category" id="category" class="block w-full border border-slate-300 rounded-lg shadow-sm py-3 px-3 focus:ring-blue-500 focus:border-blue-500 sm:text-sm cursor-pointer" required>
                                        <option value="">Pilih Kategori...</option>
                                        <option value="tops" {{ old('category') == 'tops' ? 'selected' : '' }}>Tops</option>
                                        <option value="bottoms" {{ old('category') == 'bottoms' ? 'selected' : '' }}>Bottoms</option>
                                        <option value="dresses" {{ old('category') == 'dresses' ? 'selected' : '' }}>Dresses</option>
                                        <option value="outerwear" {{ old('category') == 'outerwear' ? 'selected' : '' }}>Outerwear</option>
                                        <option value="shoes" {{ old('category') == 'shoes' ? 'selected' : '' }}>Shoes</option>
                                        <option value="accessories" {{ old('category') == 'accessories' ? 'selected' : '' }}>Accessories</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="style" class="block text-sm font-semibold text-slate-700 mb-2">Gaya</label>
                                    <select name="style" id="style" class="block w-full border border-slate-300 rounded-lg shadow-sm py-3 px-3 focus:ring-blue-500 focus:border-blue-500 sm:text-sm cursor-pointer">
                                        <option value="">Pilih Gaya...</option>
                                        <option value="casual" {{ old('style') == 'casual' ? 'selected' : '' }}>Casual</option>
                                        <option value="formal" {{ old('style') == 'formal' ? 'selected' : '' }}>Formal</option>
                                        <option value="sport" {{ old('style') == 'sport' ? 'selected' : '' }}>Sport</option>
                                        <option value="street" {{ old('style') == 'street' ? 'selected' : '' }}>Street</option>
                                        <option value="vintage" {{ old('style') == 'vintage' ? 'selected' : '' }}>Vintage</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="gender_target" class="block text-sm font-semibold text-slate-700 mb-2">Target Gender</label>
                                    <select name="gender_target" id="gender_target" class="block w-full border border-slate-300 rounded-lg shadow-sm py-3 px-3 focus:ring-blue-500 focus:border-blue-500 sm:text-sm cursor-pointer">
                                        <option value="">Pilih Gender...</option>
                                        <option value="male" {{ old('gender_target') == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender_target') == 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="unisex" {{ old('gender_target') == 'unisex' ? 'selected' : '' }}>Unisex</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="fit_type" class="block text-sm font-semibold text-slate-700 mb-2">Tipe Fit</label>
                                    <select name="fit_type" id="fit_type" class="block w-full border border-slate-300 rounded-lg shadow-sm py-3 px-3 focus:ring-blue-500 focus:border-blue-500 sm:text-sm cursor-pointer">
                                        <option value="">Pilih Fit...</option>
                                        <option value="slim" {{ old('fit_type') == 'slim' ? 'selected' : '' }}>Slim</option>
                                        <option value="regular" {{ old('fit_type') == 'regular' ? 'selected' : '' }}>Regular</option>
                                        <option value="loose" {{ old('fit_type') == 'loose' ? 'selected' : '' }}>Loose</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="dominant_color" class="block text-sm font-semibold text-slate-700 mb-2">Warna Utama</label>
                                    <input type="text" name="dominant_color" id="dominant_color" value="{{ old('dominant_color') }}" placeholder="contoh: Navy Blue"
                                           class="block w-full border border-slate-300 rounded-lg shadow-sm py-3 px-4 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>

        {{-- BULK IMPORT TAB --}}
        <div id="bulkTabContent" style="display: none;">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- LEFT COLUMN: Upload Form --}}
                <div class="lg:col-span-2 space-y-8">
                    
                    {{-- CSV Upload Section --}}
                    <div class="bg-white shadow-sm rounded-xl border border-slate-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                            <h3 class="text-lg font-semibold text-slate-900">Upload File CSV</h3>
                        </div>
                        <div class="p-6 md:p-8 space-y-6">
                            <form action="{{ route('brand.products.bulk-import') }}" method="POST" enctype="multipart/form-data" id="bulkForm">
                                @csrf
                                
                                {{-- File Upload --}}
                                <div class="relative">
                                    <label for="csvFile" class="block text-sm font-semibold text-slate-700 mb-4">Pilih File CSV</label>
                                    <div class="mt-2 flex justify-center px-6 pt-10 pb-10 border-2 border-slate-300 border-dashed rounded-xl hover:bg-slate-50 transition-colors group cursor-pointer" onclick="document.getElementById('csvFile').click()">
                                        <div class="space-y-2 text-center">
                                            <div class="mx-auto h-16 w-16 text-slate-400 group-hover:text-blue-500 transition-colors">
                                                <svg class="h-full w-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            </div>
                                            <div class="text-sm text-slate-600">
                                                <span class="font-bold text-blue-600 hover:text-blue-500">Klik untuk upload</span>
                                                <span class="pl-1">atau drag and drop</span>
                                            </div>
                                            <p class="text-xs text-slate-500">File CSV (.csv)</p>
                                        </div>
                                    </div>
                                    <input type="file" id="csvFile" name="csv_file" accept=".csv" class="sr-only" onchange="previewCSV(this)">
                                    <p class="mt-2 text-xs text-slate-500">Ukuran max: 5MB</p>
                                </div>

                                {{-- File Info --}}
                                <div id="fileInfo" style="display: none;" class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                    <p class="text-sm text-blue-800"><strong>File Dipilih:</strong> <span id="fileName"></span></p>
                                </div>

                                {{-- Submit Button --}}
                                <div class="flex items-center justify-end gap-4 pt-6">
                                    <a href="{{ route('brand.products.index') }}" class="px-6 py-3 border border-slate-300 shadow-sm text-base font-medium rounded-lg text-slate-700 bg-white hover:bg-slate-50 transition-all">
                                        Batal
                                    </a>
                                    <button type="submit" id="importBtn" disabled class="inline-flex items-center px-8 py-3 border border-transparent shadow-sm text-base font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 disabled:bg-slate-400 disabled:cursor-not-allowed transition-all">
                                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Import Produk
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- CSV Template & Instructions --}}
                    <div class="bg-white shadow-sm rounded-xl border border-slate-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                            <h3 class="text-lg font-semibold text-slate-900">Format CSV & Template</h3>
                        </div>
                        <div class="p-6 md:p-8 space-y-4">
                            <div>
                                <h4 class="font-semibold text-slate-900 mb-3">Kolom yang Diperlukan:</h4>
                                <div class="bg-slate-50 p-4 rounded-lg overflow-x-auto">
                                    <table class="w-full text-sm">
                                        <thead>
                                            <tr class="border-b border-slate-200">
                                                <th class="text-left py-2 px-2 font-semibold text-slate-700">Kolom</th>
                                                <th class="text-left py-2 px-2 font-semibold text-slate-700">Tipe</th>
                                                <th class="text-left py-2 px-2 font-semibold text-slate-700">Contoh</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-200">
                                            <tr>
                                                <td class="py-2 px-2 font-mono text-blue-600">name</td>
                                                <td class="py-2 px-2">Teks (Wajib)</td>
                                                <td class="py-2 px-2">Oversized Cotton T-Shirt</td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-2 font-mono text-blue-600">category</td>
                                                <td class="py-2 px-2">Teks (Wajib)</td>
                                                <td class="py-2 px-2">tops</td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-2 font-mono text-blue-600">price</td>
                                                <td class="py-2 px-2">Angka (Wajib)</td>
                                                <td class="py-2 px-2">99000</td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-2 font-mono text-blue-600">stock</td>
                                                <td class="py-2 px-2">Angka</td>
                                                <td class="py-2 px-2">50</td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-2 font-mono text-blue-600">description</td>
                                                <td class="py-2 px-2">Teks</td>
                                                <td class="py-2 px-2">Cotton premium quality</td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-2 font-mono text-blue-600">original_price</td>
                                                <td class="py-2 px-2">Angka</td>
                                                <td class="py-2 px-2">129000</td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-2 font-mono text-blue-600">style</td>
                                                <td class="py-2 px-2">Teks</td>
                                                <td class="py-2 px-2">casual</td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-2 font-mono text-blue-600">fit_type</td>
                                                <td class="py-2 px-2">Teks</td>
                                                <td class="py-2 px-2">regular</td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-2 font-mono text-blue-600">gender_target</td>
                                                <td class="py-2 px-2">Teks</td>
                                                <td class="py-2 px-2">male</td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-2 font-mono text-blue-600">dominant_color</td>
                                                <td class="py-2 px-2">Teks</td>
                                                <td class="py-2 px-2">Black</td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-2 font-mono text-blue-600">sizes</td>
                                                <td class="py-2 px-2">Teks</td>
                                                <td class="py-2 px-2">S,M,L,XL</td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-2 font-mono text-blue-600">colors</td>
                                                <td class="py-2 px-2">Teks</td>
                                                <td class="py-2 px-2">Black,White,Navy</td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-2 font-mono text-blue-600">image_url</td>
                                                <td class="py-2 px-2">URL (Opsional)</td>
                                                <td class="py-2 px-2">https://example.com/image.jpg</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div>
                                <h4 class="font-semibold text-slate-900 mb-3">Download Template:</h4>
                                <a href="{{ route('brand.products.csv-template') }}" class="inline-flex items-center px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg font-medium transition-all">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                    Download Template CSV
                                </a>
                                <p class="text-xs text-slate-500 mt-2">Template sudah berisi format yang benar dengan contoh data</p>
                            </div>
                        </div>
                    </div>

                    {{-- CSV Preview Section --}}
                    <div id="previewSection" style="display: none;" class="bg-white shadow-sm rounded-xl border border-slate-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                            <h3 class="text-lg font-semibold text-slate-900">Preview Data (<span id="previewCount">0</span> produk)</h3>
                        </div>
                        <div class="p-6 overflow-x-auto">
                            <table id="previewTable" class="w-full text-sm">
                                <thead class="bg-slate-50 border-b border-slate-200"></thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- RIGHT COLUMN: Info --}}
                <div class="space-y-6">
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                        <h3 class="font-semibold text-blue-900 mb-3">💡 Tips Bulk Import</h3>
                        <ul class="space-y-2 text-sm text-blue-800">
                            <li>✓ Gunakan template CSV yang disediakan</li>
                            <li>✓ Pastikan format kolom sesuai</li>
                            <li>✓ Minimum 3 kolom: name, category, price</li>
                            <li>✓ Maksimal 100 produk per file</li>
                            <li>✓ Preview data sebelum import</li>
                            <li>✓ Duplikat nama akan diabaikan</li>
                        </ul>
                    </div>

                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-6">
                        <h3 class="font-semibold text-amber-900 mb-3">⚠️ Catatan Penting</h3>
                        <ul class="space-y-2 text-sm text-amber-800">
                            <li>• Harga tanpa koma atau titik</li>
                            <li>• Pisahkan values dengan koma</li>
                            <li>• Format: S,M,L bukan S, M, L</li>
                            <li>• Status default: active</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- JavaScript --}}
    <script>
        {{-- Image Viewer for Single Product Form --}}
        function imageViewer() {
            return {
                imageUrl: '',
                fileChosen(event) {
                    this.fileToDataUrl(event, src => this.imageUrl = src)
                },
                fileToDataUrl(event, callback) {
                    if (!event.target.files.length) return
                    let file = event.target.files[0],
                        reader = new FileReader()
                    reader.readAsDataURL(file)
                    reader.onload = e => callback(e.target.result)
                },
                removeImage() {
                    this.imageUrl = '';
                    this.$refs.fileInput.value = '';
                }
            }
        }

        {{-- Tab Switching --}}
        function switchTab(tab) {
            const singleContent = document.getElementById('singleTabContent');
            const bulkContent = document.getElementById('bulkTabContent');
            const singleBtn = document.getElementById('singleTabBtn');
            const bulkBtn = document.getElementById('bulkTabBtn');

            if (tab === 'single') {
                singleContent.style.display = 'block';
                bulkContent.style.display = 'none';
                singleBtn.classList.add('border-blue-600', 'text-blue-600');
                singleBtn.classList.remove('border-transparent', 'text-slate-600');
                bulkBtn.classList.remove('border-blue-600', 'text-blue-600');
                bulkBtn.classList.add('border-transparent', 'text-slate-600');
            } else if (tab === 'bulk') {
                singleContent.style.display = 'none';
                bulkContent.style.display = 'block';
                bulkBtn.classList.add('border-blue-600', 'text-blue-600');
                bulkBtn.classList.remove('border-transparent', 'text-slate-600');
                singleBtn.classList.remove('border-blue-600', 'text-blue-600');
                singleBtn.classList.add('border-transparent', 'text-slate-600');
            }
        }

        {{-- CSV Preview Function --}}
        function previewCSV(input) {
            const file = input.files[0];
            if (!file) return;

            const fileName = document.getElementById('fileName');
            const fileInfo = document.getElementById('fileInfo');
            const previewSection = document.getElementById('previewSection');
            const importBtn = document.getElementById('importBtn');

            fileName.textContent = file.name;
            fileInfo.style.display = 'block';

            const reader = new FileReader();
            reader.onload = function(e) {
                const csv = e.target.result;
                const lines = csv.trim().split('\n');
                
                if (lines.length < 2) {
                    alert('CSV harus memiliki minimal 1 header + 1 data');
                    return;
                }

                const headers = lines[0].split(',').map(h => h.trim());
                const rows = [];
                
                for (let i = 1; i < Math.min(lines.length, 11); i++) {
                    rows.push(lines[i].split(',').map(v => v.trim()));
                }

                // Render preview table
                const table = document.getElementById('previewTable');
                const thead = table.querySelector('thead');
                const tbody = table.querySelector('tbody');

                thead.innerHTML = '<tr class="border-b border-slate-200">' +
                    headers.map(h => `<th class="text-left py-2 px-3 font-semibold text-slate-700">${h}</th>`).join('') +
                    '</tr>';

                tbody.innerHTML = rows.map(row => 
                    '<tr class="border-b border-slate-200">' +
                    row.map(cell => `<td class="py-2 px-3 text-slate-600">${cell}</td>`).join('') +
                    '</tr>'
                ).join('');

                document.getElementById('previewCount').textContent = lines.length - 1;
                previewSection.style.display = 'block';
                importBtn.disabled = false;
            };

            reader.readAsText(file);
        }
    </script>
</x-brand-layout>
