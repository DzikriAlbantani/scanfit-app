<x-brand-layout>
    <x-slot:title>My Products - ScanFit</x-slot:title>

    <div class="space-y-6">
        {{-- Header Section --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-4xl font-bold text-slate-900">Produk Saya</h1>
                <p class="text-slate-600 mt-2">Kelola dan monitor semua produk brand Anda</p>
            </div>
            <a href="{{ route('brand.products.create') }}"
               class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-xl font-medium hover:bg-blue-700 transition-all shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Produk Baru
            </a>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-lg shadow-sm animate-pulse">
                <div class="flex items-start">
                    <svg class="w-5 h-5 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        {{-- Filter & Stats Bar --}}
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                {{-- Total Products --}}
                <div class="bg-gradient-to-br from-blue-50 to-blue-100/50 rounded-xl p-4 border border-blue-200">
                    <div class="text-sm text-blue-600 font-medium mb-1">Total Produk</div>
                    <div class="text-2xl font-bold text-blue-900">{{ $products->total() }}</div>
                </div>

                {{-- Active Products --}}
                <div class="bg-gradient-to-br from-green-50 to-green-100/50 rounded-xl p-4 border border-green-200">
                    <div class="text-sm text-green-600 font-medium mb-1">Aktif</div>
                    <div class="text-2xl font-bold text-green-900">{{ $activeCount ?? 0 }}</div>
                </div>

                {{-- Inactive Products --}}
                <div class="bg-gradient-to-br from-gray-50 to-gray-100/50 rounded-xl p-4 border border-gray-200">
                    <div class="text-sm text-gray-600 font-medium mb-1">Tidak Aktif</div>
                    <div class="text-2xl font-bold text-gray-900">{{ $inactiveCount ?? 0 }}</div>
                </div>

                {{-- Total Views --}}
                <div class="bg-gradient-to-br from-purple-50 to-purple-100/50 rounded-xl p-4 border border-purple-200">
                    <div class="text-sm text-purple-600 font-medium mb-1">Total Views</div>
                    <div class="text-2xl font-bold text-purple-900">{{ $totalViews ?? 0 }}</div>
                </div>
            </div>

            {{-- Filters --}}
            <form method="GET" action="{{ route('brand.products.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    {{-- Status Filter --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                        <select name="status" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Semua Status</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>

                    {{-- Category Filter --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Kategori</label>
                        <select name="category" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Semua Kategori</option>
                            @foreach($categories ?? [] as $cat)
                                <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Search --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Cari Produk</label>
                        <div class="flex gap-2">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Nama produk..." class="flex-1 px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Sort & View Options --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-3 border-t border-slate-200">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Urutkan</label>
                        <select name="sort" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Terlama</option>
                            <option value="most_viewed" {{ request('sort') === 'most_viewed' ? 'selected' : '' }}>Paling Banyak Dilihat</option>
                            <option value="most_saved" {{ request('sort') === 'most_saved' ? 'selected' : '' }}>Paling Banyak Disimpan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Tampilan</label>
                        <div class="flex gap-2">
                            <button type="button" id="gridViewBtn" class="flex-1 px-3 py-2 border-2 border-blue-600 bg-blue-50 text-blue-600 rounded-lg font-medium transition-colors" onclick="switchView('grid')">
                                <svg class="w-5 h-5 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"></path>
                                    <path d="M3 10a1 1 0 011-1h12a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6z"></path>
                                </svg>
                            </button>
                            <button type="button" id="tableViewBtn" class="flex-1 px-3 py-2 border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors" onclick="switchView('table')">
                                <svg class="w-5 h-5 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    @if(request()->hasAny(['search', 'status', 'category', 'sort']))
                        <a href="{{ route('brand.products.index') }}" class="px-4 py-2 text-slate-600 hover:text-slate-900 border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors">
                            Reset Filter
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Products Grid/Table View --}}
        @if($products->count() > 0)
            {{-- Grid View (4 Columns) --}}
            <div id="gridView" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach($products as $product)
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-md transition-all group flex flex-col h-full">
                        {{-- Product Image --}}
                        <div class="relative overflow-hidden bg-slate-100 h-48">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            
                            {{-- Status Badge --}}
                            <div class="absolute top-2 right-2">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold
                                    {{ ($product->status ?? 'active') === 'active' 
                                        ? 'bg-green-100 text-green-700' 
                                        : 'bg-gray-100 text-gray-700' }}">
                                    {{ ucfirst($product->status ?? 'active') }}
                                </span>
                            </div>

                            {{-- Category Badge --}}
                            <div class="absolute top-2 left-2">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                    {{ $product->category }}
                                </span>
                            </div>

                            {{-- View/Save Count --}}
                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/50 to-transparent p-3 text-white">
                                <div class="flex justify-between text-xs">
                                    <span>{{ number_format($product->clicks_count ?? 0) }} views</span>
                                    <span>{{ ($product->saves_count ?? 0) }} saves</span>
                                </div>
                            </div>
                        </div>

                        {{-- Product Info --}}
                        <div class="p-4 flex-1 flex flex-col space-y-3">
                            {{-- Title & Date --}}
                            <div>
                                <h3 class="font-bold text-slate-900 line-clamp-2 text-sm group-hover:text-blue-600 transition-colors">
                                    {{ $product->name }}
                                </h3>
                                <p class="text-xs text-slate-500 mt-0.5">
                                    {{ $product->created_at->format('d M Y') }}
                                </p>
                            </div>

                            {{-- Price --}}
                            <div class="border-t border-slate-200 pt-2">
                                <p class="text-lg font-bold text-slate-900">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </p>
                            </div>

                            {{-- Stock --}}
                            <div class="grid grid-cols-2 gap-2 py-2 px-2 bg-slate-50 rounded text-center text-xs">
                                <div>
                                    <p class="text-slate-600">Stok</p>
                                    <p class="font-bold {{ ($product->stock ?? 0) > 0 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $product->stock ?? 0 }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-slate-600">Views</p>
                                    <p class="font-bold text-blue-600">
                                        {{ number_format($product->clicks_count ?? 0) }}
                                    </p>
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="grid grid-cols-3 gap-1.5 mt-auto">
                                <a href="{{ route('products.show', $product) }}" target="_blank"
                                   class="p-1.5 text-center text-blue-600 border border-blue-200 rounded hover:bg-blue-50 transition-colors" title="Lihat">
                                    <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>

                                <a href="{{ route('brand.products.edit', $product) }}"
                                   class="p-1.5 text-center text-slate-600 border border-slate-300 rounded hover:bg-slate-100 transition-colors" title="Edit">
                                    <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>

                                <form id="deleteProductForm{{ $product->id }}" method="POST" action="{{ route('brand.products.destroy', $product) }}"
                                      class="inline-block w-full">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="showDeleteProductConfirm('{{ addslashes($product->name) }}', {{ $product->id }})" class="w-full p-1.5 text-center text-red-600 border border-red-200 rounded hover:bg-red-50 transition-colors" title="Hapus">
                                        <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Table View --}}
            <div id="tableView" class="hidden bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[900px]">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-slate-900">Produk</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-slate-900">Kategori</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-slate-900">Harga</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-slate-900">Views</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-slate-900">Saves</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-slate-900">Stok</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-slate-900">Status</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-slate-900">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @foreach($products as $product)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    {{-- Product Name --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                                                 class="w-10 h-10 rounded object-cover">
                                            <div>
                                                <p class="font-medium text-slate-900 line-clamp-1">{{ $product->name }}</p>
                                                <p class="text-xs text-slate-500">{{ $product->created_at->format('d M Y') }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Category --}}
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                            {{ $product->category }}
                                        </span>
                                    </td>

                                    {{-- Price --}}
                                    <td class="px-6 py-4">
                                        <p class="font-bold text-slate-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                        @if($product->original_price && $product->original_price > $product->price)
                                            <p class="text-xs text-slate-400 line-through">Rp {{ number_format($product->original_price, 0, ',', '.') }}</p>
                                        @endif
                                    </td>

                                    {{-- Views --}}
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-700 font-semibold text-sm">
                                            {{ number_format($product->clicks_count ?? 0) }}
                                        </span>
                                    </td>

                                    {{-- Saves --}}
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-purple-100 text-purple-700 font-semibold text-sm">
                                            {{ ($product->saves_count ?? 0) }}
                                        </span>
                                    </td>

                                    {{-- Stock --}}
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center justify-center px-3 py-1 rounded-full text-sm font-bold {{ ($product->stock ?? 0) > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                            {{ $product->stock ?? 0 }}
                                        </span>
                                    </td>

                                    {{-- Status --}}
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ ($product->status ?? 'active') === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                            {{ ucfirst($product->status ?? 'active') }}
                                        </span>
                                    </td>

                                    {{-- Actions --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('products.show', $product) }}" target="_blank"
                                               class="p-2 text-blue-600 hover:bg-blue-50 rounded transition-colors" title="Lihat">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>

                                            <a href="{{ route('brand.products.edit', $product) }}"
                                               class="p-2 text-slate-600 hover:bg-slate-100 rounded transition-colors" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>

                                            <form id="deleteProductForm{{ $product->id }}" method="POST" action="{{ route('brand.products.destroy', $product) }}"
                                                  class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="showDeleteProductConfirm('{{ addslashes($product->name) }}', {{ $product->id }})" class="p-2 text-red-600 hover:bg-red-50 rounded transition-colors" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination --}}
            <div class="flex justify-center py-6">
                <div class="bg-white rounded-xl border border-slate-200 px-6 py-4">
                    {{ $products->links() }}
                </div>
            </div>

            {{-- Summary --}}
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-200 p-4 text-center">
                <p class="text-sm text-slate-700">
                    Menampilkan <strong>{{ $products->count() }}</strong> dari <strong>{{ $products->total() }}</strong> produk
                </p>
            </div>

            <script>
                function switchView(view) {
                    const gridView = document.getElementById('gridView');
                    const tableView = document.getElementById('tableView');
                    const gridBtn = document.getElementById('gridViewBtn');
                    const tableBtn = document.getElementById('tableViewBtn');

                    if (view === 'grid') {
                        gridView.classList.remove('hidden');
                        tableView.classList.add('hidden');
                        gridBtn.classList.add('border-2', 'border-blue-600', 'bg-blue-50', 'text-blue-600');
                        gridBtn.classList.remove('border', 'border-slate-300');
                        tableBtn.classList.remove('border-2', 'border-blue-600', 'bg-blue-50', 'text-blue-600');
                        tableBtn.classList.add('border', 'border-slate-300');
                    } else if (view === 'table') {
                        gridView.classList.add('hidden');
                        tableView.classList.remove('hidden');
                        tableBtn.classList.add('border-2', 'border-blue-600', 'bg-blue-50', 'text-blue-600');
                        tableBtn.classList.remove('border', 'border-slate-300');
                        gridBtn.classList.remove('border-2', 'border-blue-600', 'bg-blue-50', 'text-blue-600');
                        gridBtn.classList.add('border', 'border-slate-300');
                    }
                }
            </script>
        @else
            {{-- Empty State --}}
            <div class="bg-gradient-to-br from-slate-50 to-slate-100 rounded-3xl p-16 text-center border border-slate-200">
                <svg class="w-20 h-20 mx-auto text-slate-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <h3 class="text-2xl font-bold text-slate-900 mb-2">Belum Ada Produk</h3>
                <p class="text-slate-600 mb-8 text-lg">Mulai bangun brand Anda dengan menambahkan produk pertama</p>
                <a href="{{ route('brand.products.create') }}" 
                   class="inline-flex items-center px-8 py-4 bg-blue-600 text-white rounded-xl font-medium hover:bg-blue-700 transition-all shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Produk Pertama
                </a>
            </div>
        @endif
    </div>
</x-brand-layout>
