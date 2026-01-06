<x-layout>
    <x-slot:title>{{ $brand->name }}</x-slot:title>

    <div class="min-h-screen bg-white py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white p-8">
                <div class="flex items-center space-x-6 mb-8">
                    <div class="w-24 h-24 rounded-xl overflow-hidden bg-white flex items-center justify-center border border-slate-200 shadow-sm p-2">
                        <img src="{{ $brand->logo_url ?? 'https://via.placeholder.com/180x180.png?text=Brand' }}" alt="{{ $brand->name }}" class="max-w-full max-h-full object-contain">
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-slate-900">{{ $brand->name }}</h1>
                        <p class="text-slate-600">{{ $brand->description ?? 'Brand fashion terpercaya.' }}</p>
                    </div>
                </div>

                <h2 class="text-2xl font-bold text-slate-900 mb-6">Produk {{ $brand->name }}</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @forelse($products as $item)
                        <a href="{{ route('products.show', $item) }}" class="group bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col h-full overflow-hidden">
                            <div class="relative aspect-[4/5] overflow-hidden bg-gray-100 border-b border-slate-100">
                                <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            </div>
                            <div class="p-5 flex flex-col flex-grow">
                                <h3 class="text-slate-900 font-bold text-lg leading-tight line-clamp-2 mb-2 group-hover:text-blue-800 transition-colors">
                                    {{ $item->name }}
                                </h3>
                                <div class="mt-auto pt-4 border-t border-slate-50">
                                    <p class="text-lg font-extrabold text-slate-900">
                                        Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-full py-20 text-center">
                            <p class="text-slate-600">Belum ada produk dari brand ini.</p>
                        </div>
                    @endforelse
                </div>

                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-layout></content>
<parameter name="filePath">d:\SCANFIT\proyek-scanfit\resources\views\brand\show.blade.php