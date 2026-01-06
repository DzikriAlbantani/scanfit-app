<x-brand-layout>
    <x-slot:title>Edit Product - ScanFit</x-slot:title>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-10">
            <h1 class="text-3xl font-bold text-slate-900">Edit Produk</h1>
            <p class="text-base text-slate-600 mt-2">Sesuaikan detail produk agar seragam dengan tampilan tambah produk.</p>
        </div>

        <form action="{{ route('brand.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

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
                                <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" placeholder="contoh: Oversized Cotton T-Shirt"
                                       class="block w-full border border-slate-300 rounded-lg shadow-sm py-3 px-4 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('name') border-red-300 @enderror" required>
                                @error('name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi</label>
                                <textarea name="description" id="description" rows="6" placeholder="Jelaskan material, ukuran, gaya, dan tips perawatan..."
                                          class="block w-full border border-slate-300 rounded-lg shadow-sm py-3 px-4 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('description') border-red-300 @enderror">{{ old('description', $product->description) }}</textarea>
                                @error('description') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- PRODUCT IMAGE --}}
                    <div class="bg-white shadow-sm rounded-xl border border-slate-200 overflow-hidden" x-data="imageViewer('{{ $product->image_url }}')">
                        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                            <h3 class="text-lg font-semibold text-slate-900">Foto Produk</h3>
                        </div>
                        <div class="p-6 md:p-8">
                            <label class="block text-sm font-semibold text-slate-700 mb-4">Foto Utama</label>

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
                                    <button type="button" @click="$refs.fileInput.click()" class="absolute top-2 right-2 bg-white/90 text-slate-700 p-2 rounded-full hover:bg-white shadow-md transition-colors font-bold text-xs flex items-center gap-1 backdrop-blur-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                        Ganti
                                    </button>
                                    <div class="absolute bottom-0 left-0 right-0 bg-black/50 text-white text-xs py-2 text-center backdrop-blur-sm">
                                        Current Image / Preview
                                    </div>
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
                                    @php $selectedSizes = old('sizes', $product->sizes ?? []) @endphp
                                    @foreach(['XS', 'S', 'M', 'L', 'XL', 'XXL'] as $size)
                                        <div class="relative">
                                            <input type="checkbox" name="sizes[]" id="size_{{ $size }}" value="{{ $size }}" 
                                                   class="peer sr-only" {{ in_array($size, $selectedSizes) ? 'checked' : '' }}>
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
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
                                    @php $selectedColors = old('colors', $product->colors ?? []) @endphp
                                    @foreach(['Black', 'White', 'Red', 'Blue', 'Green', 'Yellow', 'Purple', 'Pink', 'Gray', 'Brown'] as $color)
                                        <div class="relative flex items-center p-2 rounded-lg hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-200">
                                            <input type="checkbox" name="colors[]" id="color_{{ $color }}" value="{{ $color }}" 
                                                   class="h-4 w-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500 cursor-pointer" {{ in_array($color, $selectedColors) ? 'checked' : '' }}>
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
                            <div>
                                <label for="shopee_url" class="block text-sm font-semibold text-slate-700 mb-2">Shopee</label>
                                <input type="url" name="link_shopee" id="shopee_url" value="{{ old('link_shopee', $product->link_shopee) }}"
                                       placeholder="https://www.shopee.co.id/product..."
                                       class="block w-full border border-slate-300 rounded-lg shadow-sm py-3 px-4 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="tokopedia_url" class="block text-sm font-semibold text-slate-700 mb-2">Tokopedia</label>
                                <input type="url" name="link_tokopedia" id="tokopedia_url" value="{{ old('link_tokopedia', $product->link_tokopedia) }}"
                                       placeholder="https://www.tokopedia.com/product..."
                                       class="block w-full border border-slate-300 rounded-lg shadow-sm py-3 px-4 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="lazada_url" class="block text-sm font-semibold text-slate-700 mb-2">Lazada</label>
                                <input type="url" name="link_lazada" id="lazada_url" value="{{ old('link_lazada', $product->link_lazada) }}"
                                       placeholder="https://www.lazada.co.id/product..."
                                       class="block w-full border border-slate-300 rounded-lg shadow-sm py-3 px-4 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan Perubahan
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
                                    <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" min="0" step="1000"
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
                                    <input type="number" name="original_price" id="original_price" value="{{ old('original_price', $product->original_price) }}" min="0" step="1000"
                                           class="flex-1 focus:ring-blue-500 focus:border-blue-500 block w-full min-w-0 rounded-none rounded-r-lg border border-slate-300 sm:text-sm py-3" placeholder="0">
                                </div>
                                <p class="mt-2 text-xs text-slate-500">Isi jika ingin tampil harga diskon (strikethrough)</p>
                                @error('original_price') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div class="pt-4 border-t border-slate-100">
                                <label for="stock" class="block text-sm font-semibold text-slate-700 mb-2">Stok</label>
                                <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" min="0"
                                       class="block w-full border border-slate-300 rounded-lg shadow-sm py-3 px-4 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                @error('stock') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- ORGANISASI --}}
                    <div class="bg-white shadow-sm rounded-xl border border-slate-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                            <h3 class="text-lg font-semibold text-slate-900">Organisasi</h3>
                        </div>
                        <div class="p-6 space-y-5">
                            <div>
                                <label for="category" class="block text-sm font-semibold text-slate-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                                <select name="category" id="category" class="block w-full border border-slate-300 rounded-lg shadow-sm py-3 px-3 focus:ring-blue-500 focus:border-blue-500 sm:text-sm cursor-pointer" required>
                                    <option value="">Pilih Kategori...</option>
                                    <option value="Atasan" {{ old('category', $product->category) == 'Atasan' ? 'selected' : '' }}>Atasan (Tops)</option>
                                    <option value="Bawahan" {{ old('category', $product->category) == 'Bawahan' ? 'selected' : '' }}>Bawahan (Bottoms)</option>
                                    <option value="Dress" {{ old('category', $product->category) == 'Dress' ? 'selected' : '' }}>Dress</option>
                                    <option value="Outerwear" {{ old('category', $product->category) == 'Outerwear' ? 'selected' : '' }}>Outerwear</option>
                                    <option value="Shoes" {{ old('category', $product->category) == 'Shoes' ? 'selected' : '' }}>Shoes</option>
                                    <option value="Aksesoris" {{ old('category', $product->category) == 'Aksesoris' ? 'selected' : '' }}>Aksesoris (Accessories)</option>
                                </select>
                                @error('category') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="style" class="block text-sm font-semibold text-slate-700 mb-2">Gaya</label>
                                <select name="style" id="style" class="block w-full border border-slate-300 rounded-lg shadow-sm py-3 px-3 focus:ring-blue-500 focus:border-blue-500 sm:text-sm cursor-pointer">
                                    <option value="">Pilih Gaya...</option>
                                    <option value="casual" {{ old('style', $product->style) == 'casual' ? 'selected' : '' }}>Casual</option>
                                    <option value="formal" {{ old('style', $product->style) == 'formal' ? 'selected' : '' }}>Formal</option>
                                    <option value="sport" {{ old('style', $product->style) == 'sport' ? 'selected' : '' }}>Sport</option>
                                    <option value="street" {{ old('style', $product->style) == 'street' ? 'selected' : '' }}>Street</option>
                                    <option value="vintage" {{ old('style', $product->style) == 'vintage' ? 'selected' : '' }}>Vintage</option>
                                </select>
                            </div>

                            <div>
                                <label for="gender_target" class="block text-sm font-semibold text-slate-700 mb-2">Target Gender</label>
                                <select name="gender_target" id="gender_target" class="block w-full border border-slate-300 rounded-lg shadow-sm py-3 px-3 focus:ring-blue-500 focus:border-blue-500 sm:text-sm cursor-pointer">
                                    <option value="">Pilih Gender...</option>
                                    <option value="male" {{ old('gender_target', $product->gender_target) == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender_target', $product->gender_target) == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="unisex" {{ old('gender_target', $product->gender_target) == 'unisex' ? 'selected' : '' }}>Unisex</option>
                                </select>
                            </div>

                            <div>
                                <label for="fit_type" class="block text-sm font-semibold text-slate-700 mb-2">Tipe Fit</label>
                                <select name="fit_type" id="fit_type" class="block w-full border border-slate-300 rounded-lg shadow-sm py-3 px-3 focus:ring-blue-500 focus:border-blue-500 sm:text-sm cursor-pointer">
                                    <option value="">Pilih Fit...</option>
                                    <option value="slim" {{ old('fit_type', $product->fit_type) == 'slim' ? 'selected' : '' }}>Slim</option>
                                    <option value="regular" {{ old('fit_type', $product->fit_type) == 'regular' ? 'selected' : '' }}>Regular</option>
                                    <option value="loose" {{ old('fit_type', $product->fit_type) == 'loose' ? 'selected' : '' }}>Loose</option>
                                </select>
                            </div>

                            <div>
                                <label for="dominant_color" class="block text-sm font-semibold text-slate-700 mb-2">Warna Utama</label>
                                <input type="text" name="dominant_color" id="dominant_color" value="{{ old('dominant_color', $product->dominant_color) }}" placeholder="contoh: Navy Blue"
                                       class="block w-full border border-slate-300 rounded-lg shadow-sm py-3 px-4 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>

    <script>
        function imageViewer(initialUrl = '') {
            return {
                imageUrl: initialUrl,
                fileChosen(event) {
                    this.fileToDataUrl(event, src => this.imageUrl = src)
                },
                fileToDataUrl(event, callback) {
                    if (!event.target.files.length) return
                    const file = event.target.files[0];
                    const reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = e => callback(e.target.result);
                }
            }
        }
    </script>
</x-brand-layout>