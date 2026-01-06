<x-layout>
    <x-slot:title>Profil Pengguna</x-slot:title>

    <div x-data="{ activeTab: 'personalisasi' }" class="min-h-screen bg-slate-50 pt-48 pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @php
                // Always refresh user data to get latest subscription status
                $user = auth()->user();
                $user->refresh();
            @endphp

            @if (session('status') === 'profile-updated')
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
                     class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center shadow-sm" role="alert">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="font-medium">Profil berhasil diperbarui!</span>
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8 mb-8 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-blue-50 rounded-full blur-3xl opacity-50"></div>
                
                <div class="flex flex-col md:flex-row items-center justify-between relative z-10 gap-6">
                    <div class="flex items-center space-x-6">
                        <div class="relative">
                            <img src="{{ $user->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=2563EB&color=fff' }}" 
                                 alt="Profile" 
                                 class="w-24 h-24 rounded-full object-cover ring-4 ring-blue-50 shadow-md">
                        </div>
                        <div>
                            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $user->name }}</h1>
                            <p class="text-blue-600 font-medium">
                                {{ '@' . Str::before($user->email, '@') }}
                            </p>
                            <p class="text-slate-600 text-sm mt-2 max-w-md leading-relaxed">
                                {{ $profile->bio ?? 'Belum ada bio singkat.' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-8 bg-slate-50 px-8 py-4 rounded-2xl border border-slate-200">
                        <div class="text-center">
                            <p class="text-2xl font-bold text-slate-900">{{ $scanCount ?? 0 }}</p>
                            <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Scans</p>
                        </div>
                        <div class="w-px h-10 bg-slate-200"></div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-slate-900">{{ $savedCount ?? 0 }}</p>
                            <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Saved</p>
                        </div>
                        <div class="w-px h-10 bg-slate-200"></div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-slate-900">{{ $likeCount ?? 0 }}</p>
                            <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Likes</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex space-x-1 bg-white p-1 rounded-xl border border-slate-200 shadow-sm mb-6 w-fit">
                <button @click="activeTab = 'personalisasi'" 
                        :class="activeTab === 'personalisasi' ? 'bg-blue-600 text-white shadow-md' : 'text-slate-600 hover:bg-slate-50'" 
                        class="px-6 py-2.5 rounded-lg text-sm font-medium transition-all duration-200">
                    Personalisasi
                </button>
                <button @click="activeTab = 'history'" 
                        :class="activeTab === 'history' ? 'bg-blue-600 text-white shadow-md' : 'text-slate-600 hover:bg-slate-50'" 
                        class="px-6 py-2.5 rounded-lg text-sm font-medium transition-all duration-200">
                    Riwayat Scan
                </button>
                <button @click="activeTab = 'aktivitas'" 
                        :class="activeTab === 'aktivitas' ? 'bg-blue-600 text-white shadow-md' : 'text-slate-600 hover:bg-slate-50'" 
                        class="px-6 py-2.5 rounded-lg text-sm font-medium transition-all duration-200">
                    Aktivitas
                </button>
                <button @click="activeTab = 'subscription'" 
                        :class="activeTab === 'subscription' ? 'bg-blue-600 text-white shadow-md' : 'text-slate-600 hover:bg-slate-50'" 
                        class="px-6 py-2.5 rounded-lg text-sm font-medium transition-all duration-200">
                    Langganan
                </button>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8 min-h-[500px]">
                
                <div x-show="activeTab === 'personalisasi'" x-transition.opacity.duration.300ms>
                    <div class="flex justify-between items-center mb-8">
                        <div>
                            <h2 class="text-xl font-bold text-slate-900">Edit Profil</h2>
                            <p class="text-gray-500 text-sm mt-1">Sesuaikan informasi pribadi dan preferensi gaya Anda.</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        @method('PATCH')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                            <div class="md:col-span-2 pb-2 border-b border-gray-100">
                                <h3 class="text-sm font-semibold text-blue-600 uppercase tracking-wider">Informasi Dasar</h3>
                            </div>

                            <div class="md:col-span-1">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                                       class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                                @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="md:col-span-1">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                <input type="email" value="{{ $user->email }}" disabled 
                                       class="w-full bg-gray-100 border border-gray-200 rounded-xl px-4 py-2.5 text-gray-500 cursor-not-allowed">
                                <p class="text-xs text-gray-400 mt-1">Email tidak dapat diubah.</p>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Update Foto Profil</label>
                                <div class="flex items-center space-x-4">
                                    <div class="flex-1">
                                        <input type="file" name="avatar" accept="image/*" 
                                            class="block w-full text-sm text-gray-500
                                            file:mr-4 file:py-2.5 file:px-4
                                            file:rounded-xl file:border-0
                                            file:text-sm file:font-semibold
                                            file:bg-blue-50 file:text-blue-700
                                            hover:file:bg-blue-100 cursor-pointer">
                                        <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, GIF. Maksimal 2MB.</p>
                                    </div>
                                </div>
                                @error('avatar') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Bio</label>
                                <textarea name="bio" rows="3" placeholder="Ceritakan sedikit tentang style Anda..."
                                          class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">{{ old('bio', $profile->bio ?? '') }}</textarea>
                            </div>

                            <div class="md:col-span-2 pb-2 border-b border-gray-100 mt-4">
                                <h3 class="text-sm font-semibold text-blue-600 uppercase tracking-wider">Fisik & Preferensi</h3>
                            </div>

                            <div class="md:col-span-1">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Gaya Fashion</label>
                                <select name="style_preference" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                                    <option value="">Pilih Gaya</option>
                                    @foreach(['casual', 'formal', 'sport', 'street', 'vintage', 'minimal'] as $style)
                                        <option value="{{ $style }}" {{ old('style_preference', $profile->style_preference ?? '') == $style ? 'selected' : '' }}>
                                            {{ ucfirst($style) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="md:col-span-1">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Warna Kulit</label>
                                <select name="skin_tone" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                                    <option value="">Pilih Tone</option>
                                    @foreach(['light', 'medium', 'tan', 'dark'] as $tone)
                                        <option value="{{ $tone }}" {{ old('skin_tone', $profile->skin_tone ?? '') == $tone ? 'selected' : '' }}>
                                            {{ ucfirst($tone) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="md:col-span-1 grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tinggi (cm)</label>
                                    <input type="number" name="height" value="{{ old('height', $profile->height ?? '') }}" 
                                           class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Berat (kg)</label>
                                    <input type="number" name="weight" value="{{ old('weight', $profile->weight ?? '') }}" 
                                           class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                                </div>
                            </div>

                            <div class="md:col-span-1">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Ukuran Pakaian</label>
                                <select name="body_size" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                                    <option value="">Pilih Ukuran</option>
                                    @foreach(['XS', 'S', 'M', 'L', 'XL', 'XXL'] as $size)
                                        <option value="{{ $size }}" {{ old('body_size', $profile->body_size ?? '') == $size ? 'selected' : '' }}>
                                            {{ $size }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-3">Warna Favorit</label>
                                <div class="flex flex-wrap gap-3">
                                    @php
                                        $colors = ['Hitam', 'Putih', 'Abu', 'Navy', 'Merah', 'Hijau', 'Kuning', 'Pink', 'Coklat'];
                                        $selectedColors = explode(',', $profile->favorite_color ?? '');
                                    @endphp
                                    @foreach($colors as $color)
                                        <label class="cursor-pointer group relative">
                                            <input type="checkbox" name="favorite_colors[]" value="{{ $color }}" 
                                                   {{ in_array($color, $selectedColors) ? 'checked' : '' }} 
                                                   class="peer sr-only">
                                            <span class="px-4 py-2 rounded-full text-sm border border-gray-200 bg-white text-gray-600 peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600 transition-all hover:border-blue-400 select-none inline-block shadow-sm">
                                                {{ $color }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end pt-6 border-t border-gray-100">
                            <button type="submit" class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-blue-500/30 hover:shadow-blue-500/40 hover:-translate-y-0.5 transition-all">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>

                <div x-show="activeTab === 'history'" x-transition.opacity style="display: none;">
                    @if($scans && $scans->count() > 0)
                        <div class="space-y-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Riwayat Scan Outfit</h3>
                            
                            @foreach($scans as $scan)
                                @php
                                    $result = $scan->scan_result;
                                    // Cek jika data masih berupa string JSON (diawali kurung kurawal), lalu ubah jadi Array
                                    if (is_string($result) && (Str::startsWith($result, '{') || Str::startsWith($result, '['))) {
                                        $result = json_decode($result, true);
                                    }
                                @endphp

                                <div class="bg-gray-50 rounded-xl p-4 flex items-center space-x-4 border border-gray-100 hover:shadow-sm transition-all">
                                    <img src="{{ asset('storage/' . $scan->image_path) }}" alt="Scan Image" class="w-16 h-16 rounded-lg object-cover bg-gray-200 border border-gray-200">
                                    
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs text-gray-500 mb-1">{{ $scan->created_at->format('d M Y, H:i') }}</p>
                                        
                                        <div class="flex items-center gap-2 mb-1">
                                            <h4 class="text-gray-900 font-bold text-base">Match: {{ $scan->match_percentage }}%</h4>
                                            @if($scan->match_percentage >= 80)
                                                <span class="bg-green-100 text-green-700 text-[10px] font-bold px-2 py-0.5 rounded-full">High</span>
                                            @endif
                                        </div>

                                        <div class="text-sm text-gray-600 truncate">
                                            @if(is_array($result))
                                                <span class="font-semibold text-blue-600">{{ $result['style_name'] ?? 'Style Terdeteksi' }}</span>
                                                
                                                @if(isset($result['description']))
                                                    <span class="mx-1 text-gray-300">|</span>
                                                    <span>{{ Str::limit($result['description'], 60) }}</span>
                                                @endif
                                            @else
                                                {{ Str::limit($scan->scan_result, 60) }}
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <a href="/scan/{{ $scan->id }}" class="text-blue-600 hover:text-white border border-blue-200 hover:bg-blue-600 font-medium text-xs px-4 py-2 rounded-lg transition-all whitespace-nowrap">
                                        Lihat Detail
                                    </a>
                                </div>
                            @endforeach

                            <div class="mt-4 pt-4 border-t border-gray-100">
                                {{ $scans->links() }}
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="bg-gray-50 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 border border-gray-100">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">Riwayat Scan Kosong</h3>
                            <p class="text-gray-500 mt-1">Anda belum melakukan scan outfit apapun.</p>
                            <a href="/scan" class="text-white bg-blue-600 px-6 py-2.5 rounded-xl font-medium mt-6 inline-block hover:bg-blue-700 transition-colors shadow-sm shadow-blue-200">
                                Mulai Scan Sekarang &rarr;
                            </a>
                        </div>
                    @endif
                </div>

                <div x-show="activeTab === 'aktivitas'" x-transition.opacity style="display: none;">
                    @if(isset($activities) && $activities->count() > 0)
                        <div class="space-y-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Aktivitas Terbaru</h3>
                            @foreach($activities as $act)
                                <div class="bg-gray-50 rounded-xl p-4 flex items-center space-x-4 border border-gray-100 hover:shadow-sm transition-all">
                                    <div class="w-16 h-16 rounded-lg border flex items-center justify-center flex-shrink-0 {{ $act['kind'] === 'like' ? 'bg-red-50 border-red-100' : 'bg-blue-50 border-blue-100' }}">
                                        @if($act['kind'] === 'like')
                                            <svg class="w-8 h-8 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                            </svg>
                                        @else
                                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5v14l7-5 7 5V5a2 2 0 00-2-2H7a2 2 0 00-2 2z" />
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($act['created_at'])->format('d M Y, H:i') }}</p>
                                        <p class="text-gray-900 font-medium truncate">{{ $act['title'] }}</p>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 capitalize mt-1">
                                            {{ $act['type'] }}
                                        </span>
                                    </div>
                                    @if(!empty($act['url']))
                                        <a href="{{ $act['url'] }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm px-3 py-1.5 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                                            Lihat
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="bg-gray-50 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 border border-gray-100">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">Belum Ada Aktivitas</h3>
                            <p class="text-gray-500 mt-1">Aktivitas like dan simpan Anda akan muncul di sini.</p>
                            <a href="/explore" class="text-white bg-blue-600 px-6 py-2.5 rounded-xl font-medium mt-6 inline-block hover:bg-blue-700 transition-colors shadow-sm">
                                Jelajahi Outfit &rarr;
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Subscription Tab -->
                <div x-show="activeTab === 'subscription'" x-transition.opacity style="display: none;">
                    @php
                        // Use refreshed user data
                        $user = auth()->user();
                        $user->refresh();
                        $isPremium = $user->isPremium();
                        $plan = $user->subscription_plan ?? 'basic';
                        $expiresAt = $user->subscription_expires_at;
                    @endphp

                    <div class="space-y-6">
                        <div>
                            <h2 class="text-xl font-bold text-slate-900 mb-2">Status Langganan</h2>
                            <p class="text-gray-500 text-sm">Kelola paket langganan dan dapatkan akses ke fitur premium.</p>
                        </div>

                        <!-- Current Plan Card -->
                        <div class="bg-gradient-to-br {{ $isPremium ? 'from-indigo-50 to-purple-50 border-2 border-indigo-200' : 'from-slate-50 to-gray-50 border border-gray-200' }} rounded-2xl p-6 sm:p-8">
                            <div class="flex items-start justify-between mb-6">
                                <div>
                                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full {{ $isPremium ? 'bg-indigo-100 text-indigo-700' : 'bg-slate-100 text-slate-700' }} text-xs font-bold mb-3">
                                        <span class="w-2 h-2 rounded-full {{ $isPremium ? 'bg-indigo-500' : 'bg-slate-500' }}"></span>
                                        {{ $isPremium ? 'AKTIF' : 'GRATIS' }}
                                    </div>
                                    <h3 class="text-3xl font-extrabold text-slate-900 capitalize">{{ $plan }}</h3>
                                    <p class="text-slate-600 mt-2">
                                        @if($isPremium && $expiresAt)
                                            Berlaku hingga <span class="font-bold text-indigo-600">{{ $expiresAt->format('d M Y') }}</span>
                                        @elseif($isPremium)
                                            Paket premium Anda aktif
                                        @else
                                            Tingkatkan ke paket premium untuk akses unlimited
                                        @endif
                                    </p>
                                </div>
                                @if($isPremium)
                                    <div class="text-right">
                                        <div class="text-2xl font-bold text-indigo-600">
                                            @if($expiresAt)
                                                <span class="text-sm text-slate-600 block mb-1">Berakhir dalam</span>
                                                <span>{{ $expiresAt->diffInDays(now()) }}</span>
                                                <span class="text-sm text-slate-600">hari</span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Benefits Grid -->
                            @php
                                $benefits = config('pricing.plans.' . $plan . '.features') ?? [];
                            @endphp
                            @if($benefits)
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-6 pt-6 border-t {{ $isPremium ? 'border-indigo-200' : 'border-gray-200' }}">
                                @foreach([
                                    ['label' => 'Scan/Bulan', 'key' => 'scans_per_month'],
                                    ['label' => 'Item Closet', 'key' => 'closet_items'],
                                    ['label' => 'Album', 'key' => 'albums']
                                ] as $benefit)
                                    @php
                                        $value = $benefits[$benefit['key']] ?? 'Basic';
                                        $displayValue = $value === 'unlimited' ? '∞' : $value;
                                    @endphp
                                    <div class="text-center">
                                        <p class="text-2xl font-bold {{ $isPremium ? 'text-indigo-600' : 'text-slate-900' }}">{{ $displayValue }}</p>
                                        <p class="text-sm text-slate-600 mt-1">{{ $benefit['label'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @if($isPremium)
                                <a href="{{ route('pricing.index') }}" class="px-6 py-3 rounded-xl bg-indigo-600 text-white font-bold hover:bg-indigo-700 transition-colors text-center shadow-sm">
                                    Upgrade Paket
                                </a>
                                <a href="{{ route('pricing.index') }}" class="px-6 py-3 rounded-xl border border-slate-300 text-slate-900 font-bold hover:bg-slate-50 transition-colors text-center">
                                    Lihat Semua Paket
                                </a>
                            @else
                                <a href="{{ route('pricing.index') }}" class="px-6 py-3 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold hover:shadow-lg transition-all text-center shadow-sm col-span-2">
                                    Upgrade ke Premium Sekarang
                                </a>
                            @endif
                        </div>

                        <!-- Usage Info -->
                        @if($isPremium)
                        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 sm:p-6">
                            <h4 class="font-semibold text-amber-900 mb-3">📋 Info Penting</h4>
                            <ul class="space-y-2 text-sm text-amber-800">
                                <li>• Paket Anda akan diperpanjang otomatis sebelum tanggal kedaluwarsa</li>
                                <li>• Jika pembayaran gagal, Anda akan mendapat notifikasi melalui email</li>
                                <li>• Anda bisa membatalkan langganan kapan saja di halaman ini</li>
                                <li>• Tidak ada biaya tersembunyi atau komitmen jangka panjang</li>
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-layout>