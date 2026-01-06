<x-layout>
    <x-slot:title>Scan Outfit</x-slot:title>

    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-blue-50 pt-48 pb-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto flex flex-col space-y-12">
            
            <div class="text-center space-y-4">
                <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">
                    Scan <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Outfitmu</span>
                </h1>
                <p class="text-base text-slate-600 max-w-2xl mx-auto leading-relaxed">
                    Upload foto outfit untuk mendapatkan analisis <span class="font-medium text-blue-600">gaya</span>, <span class="font-medium text-indigo-600">warna</span>, dan <span class="font-medium text-purple-600">rekomendasi</span> terbaik.
                </p>
                @auth
                <div class="mt-6 max-w-xl mx-auto bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                    @php
                        // Always get fresh user data from database
                        $user = auth()->user();
                        $user->refresh(); // Refresh dari database untuk data terbaru
                        $isPremium = $user->isPremium();
                        $limit = $limit ?? 10;
                        $used = $used ?? 0;
                        $remaining = max(0, $limit - $used);
                        $percent = $limit > 0 ? min(100, round(($used / max(1,$limit)) * 100)) : 0;
                    @endphp
                    @if($isPremium)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-r from-amber-100 to-yellow-100 text-amber-700">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2l2.39 4.84 5.34.78-3.86 3.76.91 5.31L10 14.77 4.22 16.69l.91-5.31L1.27 7.62l5.34-.78L10 2z"/></svg>
                                </span>
                                <div class="text-left">
                                    <div class="text-sm font-bold text-slate-900">⭐ Premium Aktif</div>
                                    <div class="text-xs text-slate-500">Paket {{ ucfirst($user->subscription_plan) }} - Scan tanpa batas</div>
                                </div>
                            </div>
                            <a href="{{ route('pricing.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800 transition px-3 py-1 bg-blue-50 rounded-full">Kelola →</a>
                        </div>
                    @else
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <div class="text-sm font-bold text-slate-900">📊 Sisa Scan Gratis</div>
                                <div class="text-xs text-slate-500 mt-0.5">Paket Basic - {{ $used }}/{{ $limit }} digunakan</div>
                            </div>
                            <div class="text-right">
                                <div class="text-lg font-bold {{ $remaining>0 ? 'text-emerald-600' : 'text-red-600' }}">{{ $remaining }}</div>
                                <div class="text-xs text-slate-500">tersisa</div>
                            </div>
                        </div>
                        <div class="w-full h-3 rounded-full bg-slate-100 overflow-hidden mb-3 border border-slate-200">
                            <div class="h-full {{ $remaining>0 ? 'bg-gradient-to-r from-emerald-500 to-green-500' : 'bg-gradient-to-r from-red-500 to-rose-500' }} transition-all duration-300" style="width: {{ $percent }}%"></div>
                        </div>
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-600">Progress: {{ $percent }}%</span>
                            <a href="{{ route('pricing.index') }}" class="inline-flex items-center gap-1 text-white font-semibold bg-gradient-to-r from-blue-600 to-indigo-600 px-3 py-1.5 rounded-full hover:shadow-md transition">
                                Upgrade Premium
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    @endif
                </div>
                @endauth
            </div>

            <form action="{{ route('scan.store') }}" method="POST" enctype="multipart/form-data" class="w-full"
                x-data="{
                    hasFile: false,
                    fileName: '',
                    filePreview: null,
                    isDragging: false,
                    isLoading: false,
                    handleDrop(event) {
                        const droppedFile = event.dataTransfer.files[0];
                        this.processFile(droppedFile);
                        this.isDragging = false;
                    },
                    handleFileSelect(event) {
                        const selectedFile = event.target.files[0];
                        this.processFile(selectedFile);
                    },
                    processFile(file) {
                        if (file) {
                            this.hasFile = true;
                            this.fileName = file.name;
                            // Membuat preview gambar
                            this.filePreview = URL.createObjectURL(file);
                            
                            // Update input file secara manual untuk data transfer (jika drag & drop)
                            const dataTransfer = new DataTransfer();
                            dataTransfer.items.add(file);
                            this.$refs.fileInput.files = dataTransfer.files;
                        }
                    },
                    resetFile() {
                        this.hasFile = false;
                        this.fileName = '';
                        this.filePreview = null;
                        this.$refs.fileInput.value = '';
                    },
                    async submitForm(event) {
                        event.preventDefault();
                        this.isLoading = true;
                        
                        const formData = new FormData(this.$el);
                        try {
                            const response = await fetch(this.$el.action, {
                                method: 'POST',
                                body: formData,
                                redirect: 'follow'
                            });
                            
                            console.log('Response status:', response.status);
                            console.log('Response URL:', response.url);
                            
                            if (response.ok) {
                                // Redirect to the final URL after following redirects
                                if (response.url) {
                                    window.location.href = response.url;
                                } else {
                                    // Fallback: wait a bit then reload
                                    setTimeout(() => window.location.reload(), 500);
                                }
                            } else {
                                this.isLoading = false;
                                console.log('Response text:', await response.text());
                                alert('Terjadi kesalahan. Silakan coba lagi.');
                            }
                        } catch (error) {
                            this.isLoading = false;
                            console.error('Fetch Error:', error);
                            alert('Terjadi kesalahan. Silakan coba lagi.');
                        }
                    }
                }"
                @submit="submitForm">
                @csrf
                
                <div class="bg-white rounded-2xl shadow-md shadow-blue-100/50 p-8 w-full relative transition-all duration-300 border border-slate-200">
                    
                    <div class="relative w-full rounded-2xl border-2 border-dashed transition-all duration-300 min-h-[320px] flex flex-col justify-center items-center overflow-hidden bg-slate-50/50"
                         :class="{'border-blue-500 bg-blue-50 ring-4 ring-blue-100': isDragging, 'border-slate-200 hover:border-blue-300 hover:bg-slate-50': !isDragging}"
                         @dragover.prevent="isDragging = true"
                         @dragleave.prevent="isDragging = false"
                         @drop.prevent="handleDrop">

                        <input type="file" id="fileInput" name="image" x-ref="fileInput"
                               @change="handleFileSelect" accept="image/jpeg,image/png,image/webp" 
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-50"
                               :class="{'pointer-events-none': hasFile}">

                        <div x-show="!hasFile" class="flex flex-col items-center justify-center text-center p-6 space-y-4 pointer-events-none">
                            <div class="bg-white rounded-2xl p-4 shadow-sm ring-1 ring-slate-100 mb-2 transition-transform duration-300"
                                 :class="{'scale-110 shadow-md': isDragging}">
                                <svg class="h-10 w-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-slate-900">Upload Foto Outfit</h3>
                                <p class="text-slate-500 text-sm mt-1">Drag & drop foto atau klik area ini</p>
                            </div>
                            <span class="inline-flex items-center px-4 py-2 rounded-full bg-blue-50 text-blue-700 text-sm font-medium">
                                JPG, PNG, WEBP
                            </span>
                        </div>

                        <div x-show="hasFile" class="flex flex-col items-center justify-center w-full h-full p-6 z-40 relative" style="display: none;">
                            
                            <div class="relative group mb-6">
                                <img :src="filePreview" class="h-48 w-auto object-contain rounded-lg shadow-md border border-slate-200">
                                <div class="absolute inset-0 bg-black/40 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <button type="button" @click="resetFile()" class="text-white hover:text-red-200 font-medium text-sm flex items-center gap-1 cursor-pointer pointer-events-auto">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        Hapus
                                    </button>
                                </div>
                            </div>

                            <div class="text-center space-y-4 w-full max-w-xs relative z-50">
                                <div class="bg-blue-50/80 backdrop-blur rounded-lg px-4 py-2 border border-blue-100">
                                    <p class="text-blue-900 font-medium text-sm truncate" x-text="fileName"></p>
                                </div>
                                
                                @php $isPremiumBtn = auth()->user()?->isPremium(); @endphp
                                <button type="submit" :disabled="isLoading || {{ $isPremiumBtn ? 'false' : (isset($remaining) && $remaining <= 0 ? 'true' : 'false') }}" class="w-full py-3.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-bold shadow-lg shadow-blue-500/30 hover:shadow-blue-500/40 hover:-translate-y-0.5 transition-all flex items-center justify-center space-x-2 cursor-pointer disabled:opacity-75 disabled:cursor-not-allowed group"
                                    x-show="!isLoading">
                                    <span>Mulai Analisa AI</span>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                </button>
                                @auth
                                @if(($remaining ?? 1) <= 0 && !auth()->user()?->isPremium())
                                <a href="{{ route('pricing.index') }}" class="block w-full mt-3 py-3.5 text-blue-700 bg-blue-50 hover:bg-blue-100 border border-blue-200 rounded-xl font-semibold text-center transition-all">
                                    Upgrade untuk Lanjut Scan
                                </a>
                                @endif
                                @endauth

                                <!-- Loading State -->
                                <div x-show="isLoading" class="w-full py-3.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-bold shadow-lg shadow-blue-500/30 flex items-center justify-center space-x-3" style="display: none;">
                                    <div class="flex space-x-1">
                                        <div class="w-2 h-2 bg-white rounded-full animate-bounce" style="animation-delay: 0s;"></div>
                                        <div class="w-2 h-2 bg-white rounded-full animate-bounce" style="animation-delay: 0.2s;"></div>
                                        <div class="w-2 h-2 bg-white rounded-full animate-bounce" style="animation-delay: 0.4s;"></div>
                                    </div>
                                    <span>AI sedang menganalisis...</span>
                                </div>
                                
                                <button type="button" @click="resetFile()" :disabled="isLoading" class="text-sm text-slate-400 hover:text-slate-600 transition-colors cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed">
                                    Ganti Foto Lain
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                 <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 text-center hover:shadow-md hover:-translate-y-1 transition-all duration-300 group">
                    <div class="bg-blue-50 rounded-2xl w-14 h-14 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 group-hover:bg-blue-100 transition-all duration-300">
                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Deteksi Gaya</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">Identifikasi gaya pakaian seperti Casual, Streetwear, atau Formal.</p>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 text-center hover:shadow-md hover:-translate-y-1 transition-all duration-300 group">
                    <div class="bg-emerald-50 rounded-2xl w-14 h-14 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 group-hover:bg-emerald-100 transition-all duration-300">
                        <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.355m0-1.355l-1.657-1.355M16 11l-4-4"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Analisis Warna</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">Deteksi warna dominan dan saran palet warna yang cocok.</p>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 text-center hover:shadow-md hover:-translate-y-1 transition-all duration-300 group">
                    <div class="bg-purple-50 rounded-2xl w-14 h-14 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 group-hover:bg-purple-100 transition-all duration-300">
                        <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Rekomendasi</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">Saran produk fashion serupa yang cocok dengan gaya Anda.</p>
                </div>
            </div>
        </div>
    </div>
</x-layout>