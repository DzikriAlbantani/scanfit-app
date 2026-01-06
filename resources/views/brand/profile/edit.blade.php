<x-brand-layout>
    <x-slot:title>Edit Brand Profile</x-slot:title>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-10">
            <p class="text-sm font-semibold text-blue-600 uppercase tracking-wide">Brand Profile</p>
            <h1 class="text-3xl font-bold text-slate-900 mt-2">Perbarui Profil Brand</h1>
            <p class="text-base text-slate-600 mt-2">Lengkapi identitas brand agar tampilan publik lebih konsisten dan profesional.</p>
        </div>

        <form action="{{ route('brand.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-10">

                {{-- MAIN CONTENT --}}
                <div class="lg:col-span-2 space-y-8">

                    {{-- Brand Info --}}
                    <div class="bg-white shadow-sm rounded-2xl border border-slate-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                            <h3 class="text-lg font-semibold text-slate-900">Identitas Brand</h3>
                            <p class="text-sm text-slate-500">Nama dan deskripsi akan tampil di halaman publik brand Anda.</p>
                        </div>
                        <div class="p-6 md:p-8 space-y-6">
                            <div>
                                <label for="brand_name" class="block text-sm font-semibold text-slate-700 mb-2">Nama Brand <span class="text-red-500">*</span></label>
                                <input type="text" name="brand_name" id="brand_name" value="{{ old('brand_name', $brand->brand_name) }}" placeholder="contoh: ScanFit Apparel"
                                       class="block w-full border border-slate-300 rounded-lg shadow-sm py-3 px-4 focus:ring-blue-500 focus:border-blue-500 transition-colors text-base @error('brand_name') border-red-300 @enderror" required>
                                @error('brand_name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi</label>
                                <textarea name="description" id="description" rows="6" placeholder="Ceritakan identitas, gaya, dan nilai brand Anda..."
                                          class="block w-full border border-slate-300 rounded-lg shadow-sm py-3 px-4 focus:ring-blue-500 focus:border-blue-500 transition-colors text-base @error('description') border-red-300 @enderror">{{ old('description', $brand->description) }}</textarea>
                                <p class="mt-2 text-xs text-slate-500">Ditampilkan pada profil publik dan hasil rekomendasi.</p>
                                @error('description') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Brand Logo --}}
                    <div class="bg-white shadow-sm rounded-2xl border border-slate-200 overflow-hidden" x-data="imageViewer('{{ $brand->logo_url ? asset($brand->logo_url) : '' }}')">
                        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                            <h3 class="text-lg font-semibold text-slate-900">Logo Brand</h3>
                            <p class="text-sm text-slate-500">Gunakan logo resolusi tinggi agar tampil tajam di seluruh aplikasi.</p>
                        </div>
                        <div class="p-6 md:p-8">
                            <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                                <div class="relative w-32 h-32 rounded-xl overflow-hidden border-2 border-slate-200 bg-slate-50 flex-shrink-0">
                                    <template x-if="imageUrl">
                                        <img :src="imageUrl" class="w-full h-full object-cover">
                                    </template>
                                    <template x-if="!imageUrl">
                                        <div class="w-full h-full flex items-center justify-center text-slate-400">
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    </template>
                                </div>

                                <div class="flex-1 space-y-3">
                                    <div class="flex items-center gap-3 flex-wrap">
                                        <label for="logo" class="cursor-pointer inline-flex items-center px-4 py-2 border border-slate-300 shadow-sm text-sm font-semibold rounded-lg text-slate-700 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                            <svg class="-ml-1 mr-2 h-5 w-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                            Unggah Logo
                                        </label>
                                        <button type="button" @click="$refs.fileInput.value=''; imageUrl='';" class="text-sm font-semibold text-slate-500 hover:text-slate-700">Reset</button>
                                        <input x-ref="fileInput" id="logo" name="logo" type="file" accept="image/*" class="sr-only" @change="fileChosen">
                                    </div>
                                    <p class="text-xs text-slate-500">Direkomendasikan 500x500px. Format: PNG/JPG/GIF. Maks 2MB.</p>
                                    @error('logo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SIDEBAR ACTIONS --}}
                <div class="lg:col-span-1">
                    <div class="bg-white shadow-sm rounded-2xl border border-slate-200 p-6 sticky top-24">
                        <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4 border-b border-slate-200 pb-3">Aksi</h3>
                        <div class="space-y-3">
                            <button type="submit" class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Simpan Perubahan
                            </button>
                            <a href="{{ route('brand.dashboard') }}" class="w-full flex justify-center py-3 px-4 border border-slate-300 rounded-lg shadow-sm text-sm font-bold text-slate-700 bg-white hover:bg-slate-50 transition-colors">
                                Batalkan
                            </a>
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