<x-layout>
    <div x-data="{ activeTab: 'personalisasi' }" class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header Card -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <img src="{{ $user->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=0D8ABC&color=fff' }}" alt="Profile" class="w-20 h-20 rounded-full object-cover">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                            <p class="text-gray-600">@{{ Str::before($user->email, '@') }}</p>
                            <p class="text-gray-500 text-sm mt-1">{{ $profile->bio ?? 'Bio singkat pengguna.' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="text-center">
                            <p class="text-2xl font-bold text-gray-900">{{ $profile->scans ?? 0 }}</p>
                            <p class="text-gray-500 text-sm">Scans</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-gray-900">{{ $profile->saved ?? 0 }}</p>
                            <p class="text-gray-500 text-sm">Saved</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-gray-900">{{ $profile->likes ?? 0 }}</p>
                            <p class="text-gray-500 text-sm">Likes</p>
                        </div>
                        <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Edit</a>
                    </div>
                </div>
            </div>

            <!-- Tab Navigation -->
            <div class="bg-gray-800 text-white rounded-lg p-4 mb-6">
                <div class="flex space-x-8">
                    <button @click="activeTab = 'personalisasi'" :class="activeTab === 'personalisasi' ? 'bg-gray-700' : ''" class="px-4 py-2 rounded-lg hover:bg-gray-700">Personalisasi</button>
                    <button @click="activeTab = 'history'" :class="activeTab === 'history' ? 'bg-gray-700' : ''" class="px-4 py-2 rounded-lg hover:bg-gray-700">History</button>
                    <button @click="activeTab = 'aktivitas'" :class="activeTab === 'aktivitas' ? 'bg-gray-700' : ''" class="px-4 py-2 rounded-lg hover:bg-gray-700">Aktivitas</button>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <!-- Personalisasi Tab -->
                <div x-show="activeTab === 'personalisasi'" x-transition>
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Data Personalisasi</h2>

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Lengkap -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="mt-1 block w-full bg-gray-50 border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Email -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" value="{{ $user->email }}" disabled class="mt-1 block w-full bg-gray-50 border border-gray-300 rounded-md px-3 py-2 cursor-not-allowed">
                        </div>

                        <!-- Bio -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Bio</label>
                            <textarea name="bio" rows="3" class="mt-1 block w-full bg-gray-50 border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('bio', $profile->bio ?? '') }}</textarea>
                        </div>

                        <!-- Gaya Fashion -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Gaya Fashion</label>
                            <select name="style_preference" class="mt-1 block w-full bg-gray-50 border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Pilih Gaya</option>
                                <option value="casual" {{ old('style_preference', $profile->style_preference) == 'casual' ? 'selected' : '' }}>Casual</option>
                                <option value="formal" {{ old('style_preference', $profile->style_preference) == 'formal' ? 'selected' : '' }}>Formal</option>
                                <option value="sport" {{ old('style_preference', $profile->style_preference) == 'sport' ? 'selected' : '' }}>Sport</option>
                                <option value="street" {{ old('style_preference', $profile->style_preference) == 'street' ? 'selected' : '' }}>Street</option>
                                <option value="vintage" {{ old('style_preference', $profile->style_preference) == 'vintage' ? 'selected' : '' }}>Vintage</option>
                                <option value="minimal" {{ old('style_preference', $profile->style_preference) == 'minimal' ? 'selected' : '' }}>Minimal</option>
                            </select>
                        </div>

                        <!-- Warna Kulit -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Warna Kulit</label>
                            <select name="skin_tone" class="mt-1 block w-full bg-gray-50 border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Pilih</option>
                                <option value="light" {{ old('skin_tone', $profile->skin_tone) == 'light' ? 'selected' : '' }}>Light</option>
                                <option value="medium" {{ old('skin_tone', $profile->skin_tone) == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="tan" {{ old('skin_tone', $profile->skin_tone) == 'tan' ? 'selected' : '' }}>Tan</option>
                                <option value="dark" {{ old('skin_tone', $profile->skin_tone) == 'dark' ? 'selected' : '' }}>Dark</option>
                            </select>
                        </div>

                        <!-- Ukuran Tubuh -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Ukuran Tubuh</label>
                            <select name="body_size" class="mt-1 block w-full bg-gray-50 border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Pilih</option>
                                <option value="XS" {{ old('body_size', $profile->body_size) == 'XS' ? 'selected' : '' }}>XS</option>
                                <option value="S" {{ old('body_size', $profile->body_size) == 'S' ? 'selected' : '' }}>S</option>
                                <option value="M" {{ old('body_size', $profile->body_size) == 'M' ? 'selected' : '' }}>M</option>
                                <option value="L" {{ old('body_size', $profile->body_size) == 'L' ? 'selected' : '' }}>L</option>
                                <option value="XL" {{ old('body_size', $profile->body_size) == 'XL' ? 'selected' : '' }}>XL</option>
                                <option value="XXL" {{ old('body_size', $profile->body_size) == 'XXL' ? 'selected' : '' }}>XXL</option>
                            </select>
                        </div>

                        <!-- Tinggi Badan -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tinggi Badan (cm)</label>
                            <input type="number" name="height" value="{{ old('height', $profile->height ?? '') }}" class="mt-1 block w-full bg-gray-50 border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Berat Badan -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Berat Badan (kg)</label>
                            <input type="number" name="weight" value="{{ old('weight', $profile->weight ?? '') }}" class="mt-1 block w-full bg-gray-50 border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Warna Favorit -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Warna Favorit</label>
                            <div class="flex flex-wrap gap-2">
                                @php
                                    $colors = ['Hitam', 'Putih', 'Abu', 'Biru', 'Merah', 'Hijau', 'Kuning', 'Pink', 'Coklat'];
                                    $selectedColors = explode(',', $profile->favorite_color ?? '');
                                @endphp
                                @foreach($colors as $color)
                                    <label class="flex items-center">
                                        <input type="checkbox" name="favorite_colors[]" value="{{ $color }}" {{ in_array($color, $selectedColors) ? 'checked' : '' }} class="mr-2">
                                        <span class="px-3 py-1 rounded-full text-sm {{ in_array($color, $selectedColors) ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }} hover:bg-blue-500 hover:text-white transition">
                                            {{ $color }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Simpan Perubahan</button>
                    </div>
                </form>
                </div>

                <!-- History Tab -->
                <div x-show="activeTab === 'history'" x-transition>
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Riwayat Scan</h2>
                    @forelse($scans as $scan)
                        <div class="border-b border-gray-200 py-4">
                            <p class="text-gray-800">{{ $scan->description ?? 'Scan item' }}</p>
                            <p class="text-sm text-gray-500">{{ $scan->created_at->format('d M Y') }}</p>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada riwayat scan</h3>
                            <p class="mt-1 text-sm text-gray-500">Mulai scan outfit untuk melihat riwayat di sini.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Aktivitas Tab -->
                <div x-show="activeTab === 'aktivitas'" x-transition>
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Aktivitas</h2>
                    @forelse($likes as $like)
                        <div class="border-b border-gray-200 py-4">
                            <p class="text-gray-800">Liked: {{ $like->item->name ?? 'Item' }}</p>
                            <p class="text-sm text-gray-500">{{ $like->created_at->format('d M Y') }}</p>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada aktivitas</h3>
                            <p class="mt-1 text-sm text-gray-500">Like item untuk melihat aktivitas di sini.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-layout>