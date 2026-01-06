<x-layout>
    <x-slot:title>Detail Pengguna - Admin</x-slot:title>

    <div class="min-h-screen bg-slate-50">
        <section class="relative overflow-hidden bg-white pb-12 pt-48 border-b border-slate-200">
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-50 rounded-full blur-3xl opacity-60 -mr-20 -mt-20 pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <a href="{{ route('admin.users') }}" class="inline-flex items-center text-sm font-bold text-blue-600 hover:text-blue-700 mb-6 group">
                    <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Kembali ke Manajemen Pengguna
                </a>

                <div class="space-y-4">
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                        Detail Pengguna
                    </h1>
                    <p class="text-base text-slate-600">
                        Informasi lengkap tentang pengguna dan aktivitasnya.
                    </p>
                </div>
            </div>
        </section>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- PROFILE CARD --}}
                <div class="bg-white rounded-2xl border border-slate-200 p-8">
                    <div class="text-center mb-6">
                        <div class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center mx-auto mb-4">
                            <span class="text-3xl font-bold text-blue-600">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                        <h2 class="text-2xl font-bold text-slate-900">{{ $user->name }}</h2>
                        <p class="text-slate-600 mt-1">{{ $user->email }}</p>
                    </div>

                    <div class="space-y-4 pt-6 border-t border-slate-200">
                        <div>
                            <p class="text-xs font-bold text-slate-600 uppercase mb-1">Status</p>
                            @if($user->is_premium)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-purple-100 text-purple-700">⭐ Premium</span>
                            @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-slate-100 text-slate-700">Free</span>
                            @endif
                        </div>
                        
                        <div>
                            <p class="text-xs font-bold text-slate-600 uppercase mb-1">Terdaftar</p>
                            <p class="text-slate-900 font-medium">{{ $user->created_at->format('d F Y H:i') }}</p>
                        </div>

                        <div>
                            <p class="text-xs font-bold text-slate-600 uppercase mb-1">Terakhir Login</p>
                            <p class="text-slate-900 font-medium">{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Belum pernah' }}</p>
                        </div>
                    </div>

                    <div class="mt-6 space-y-2">
                        <form id="deleteUserForm" action="{{ route('admin.users.delete', $user) }}" method="POST" class="w-full">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="showDeleteUserConfirm('{{ addslashes($user->name) }}', document.getElementById('deleteUserForm'))" class="w-full px-4 py-2.5 bg-red-100 text-red-700 font-bold rounded-xl hover:bg-red-200 transition">
                                🗑️ Hapus Pengguna
                            </button>
                        </form>
                    </div>
                </div>

                {{-- ACTIVITY & STATS --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- STATS --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white rounded-2xl border border-slate-200 p-6">
                            <p class="text-sm text-slate-600 mb-1">Item di Closet</p>
                            <p class="text-3xl font-bold text-blue-600">{{ $closetItems }}</p>
                        </div>
                        <div class="bg-white rounded-2xl border border-slate-200 p-6">
                            <p class="text-sm text-slate-600 mb-1">Album Outfit</p>
                            <p class="text-3xl font-bold text-purple-600">{{ $albums }}</p>
                        </div>
                    </div>

                    {{-- PROFILE INFO --}}
                    <div class="bg-white rounded-2xl border border-slate-200 p-6">
                        <h3 class="text-lg font-bold text-slate-900 mb-4">Informasi Profil</h3>
                        <div class="space-y-4">
                            @if($user->profile)
                                <div>
                                    <p class="text-xs font-bold text-slate-600 uppercase mb-1">Bio</p>
                                    <p class="text-slate-900">{{ $user->profile->bio ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-600 uppercase mb-1">Gaya Favorit</p>
                                    <p class="text-slate-900">{{ $user->profile->favorite_style ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-600 uppercase mb-1">Ukuran Pakaian</p>
                                    <p class="text-slate-900">{{ $user->profile->clothing_size ?? '-' }}</p>
                                </div>
                            @else
                                <p class="text-slate-600 text-center py-4">Profil belum dilengkapi</p>
                            @endif
                        </div>
                    </div>

                    {{-- SUBSCRIPTION INFO --}}
                    <div class="bg-white rounded-2xl border border-slate-200 p-6">
                        <h3 class="text-lg font-bold text-slate-900 mb-4">Informasi Langganan</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-slate-600">Status:</span>
                                @if($user->is_premium)
                                <span class="font-bold text-purple-600">Premium Aktif</span>
                                @else
                                <span class="font-bold text-slate-600">Free Plan</span>
                                @endif
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-600">Paket:</span>
                                <span class="font-bold text-slate-900">{{ $user->subscription_plan ?? 'None' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-600">Scan Bulan Ini:</span>
                                <span class="font-bold text-slate-900">{{ $user->scan_count_monthly ?? 0 }} / 10</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
