<x-layout>
    <x-slot:title>Pengaturan Sistem - Admin</x-slot:title>

    <div class="min-h-screen bg-slate-50">
        <section class="relative overflow-hidden bg-white pb-12 pt-48 border-b border-slate-200">
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-50 rounded-full blur-3xl opacity-60 -mr-20 -mt-20 pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="space-y-4 text-center md:text-left">
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                        Pengaturan <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">Sistem</span>
                    </h1>
                    <p class="text-base text-slate-600 max-w-2xl mx-auto md:mx-0">
                        Kelola konfigurasi dan pengaturan aplikasi Scanfit.
                    </p>
                </div>
            </div>
        </section>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- SIDEBAR MENU --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden sticky top-24">
                        <div class="p-6 border-b border-slate-200">
                            <h3 class="font-bold text-slate-900">Pengaturan</h3>
                        </div>
                        <nav class="divide-y divide-slate-200">
                            <a href="#general" class="block px-6 py-4 text-slate-600 hover:bg-slate-50 font-semibold transition">
                                ⚙️ Umum
                            </a>
                            <a href="#email" class="block px-6 py-4 text-slate-600 hover:bg-slate-50 font-semibold transition">
                                📧 Email
                            </a>
                            <a href="#storage" class="block px-6 py-4 text-slate-600 hover:bg-slate-50 font-semibold transition">
                                💾 Penyimpanan
                            </a>
                            <a href="#api" class="block px-6 py-4 text-slate-600 hover:bg-slate-50 font-semibold transition">
                                🔌 API
                            </a>
                        </nav>
                    </div>
                </div>

                {{-- MAIN CONTENT --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- GENERAL SETTINGS --}}
                    <div id="general" class="bg-white rounded-2xl border border-slate-200 p-8">
                        <h2 class="text-2xl font-bold text-slate-900 mb-6">⚙️ Pengaturan Umum</h2>
                        
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-900 mb-2">Nama Aplikasi</label>
                                <input type="text" value="SCANFIT" disabled class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-600 bg-slate-50">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-900 mb-2">Versi</label>
                                <input type="text" value="1.0.0" disabled class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-600 bg-slate-50">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-900 mb-2">Environment</label>
                                <input type="text" value="{{ app()->environment() }}" disabled class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-600 bg-slate-50">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-900 mb-2">Timezone</label>
                                <input type="text" value="{{ config('app.timezone') }}" disabled class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-600 bg-slate-50">
                            </div>

                            <div>
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" checked disabled class="w-5 h-5 rounded border-slate-300">
                                    <span class="text-sm font-medium text-slate-900">Maintenance Mode</span>
                                </label>
                                <p class="text-xs text-slate-500 mt-1">Nonaktifkan akses publik ke aplikasi</p>
                            </div>
                        </div>
                    </div>

                    {{-- EMAIL SETTINGS --}}
                    <div id="email" class="bg-white rounded-2xl border border-slate-200 p-8">
                        <h2 class="text-2xl font-bold text-slate-900 mb-6">📧 Pengaturan Email</h2>
                        
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
                            <p class="text-sm text-blue-700">
                                ℹ️ Konfigurasi email diatur melalui file <code class="font-mono bg-blue-100 px-2 py-1 rounded">.env</code>
                            </p>
                        </div>

                        <div class="space-y-4 text-slate-600">
                            <div class="flex justify-between">
                                <span>MAIL_DRIVER:</span>
                                <span class="font-mono">{{ env('MAIL_DRIVER', 'smtp') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>MAIL_FROM_ADDRESS:</span>
                                <span class="font-mono">{{ env('MAIL_FROM_ADDRESS', 'noreply@scanfit.com') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>MAIL_HOST:</span>
                                <span class="font-mono">{{ env('MAIL_HOST', 'smtp.mailtrap.io') }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- STORAGE SETTINGS --}}
                    <div id="storage" class="bg-white rounded-2xl border border-slate-200 p-8">
                        <h2 class="text-2xl font-bold text-slate-900 mb-6">💾 Penyimpanan File</h2>
                        
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-slate-600">Default Disk:</span>
                                <span class="font-semibold text-slate-900">{{ env('FILESYSTEM_DISK', 'public') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-slate-600">Visibilitas:</span>
                                <span class="font-semibold text-slate-900">{{ env('FILESYSTEM_VISIBILITY', 'private') }}</span>
                            </div>
                        </div>

                        <div class="mt-6 pt-6 border-t border-slate-200">
                            <h3 class="font-bold text-slate-900 mb-4">Kapasitas Penyimpanan</h3>
                            <div class="space-y-3">
                                <div>
                                    <div class="flex justify-between mb-2">
                                        <span class="text-sm text-slate-600">Gambar Produk</span>
                                        <span class="text-sm font-semibold text-slate-900">~250 MB</span>
                                    </div>
                                    <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-blue-500" style="width: 35%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between mb-2">
                                        <span class="text-sm text-slate-600">Foto Profil</span>
                                        <span class="text-sm font-semibold text-slate-900">~80 MB</span>
                                    </div>
                                    <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-purple-500" style="width: 12%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between mb-2">
                                        <span class="text-sm text-slate-600">Cache</span>
                                        <span class="text-sm font-semibold text-slate-900">~45 MB</span>
                                    </div>
                                    <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-emerald-500" style="width: 6%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- API SETTINGS --}}
                    <div id="api" class="bg-white rounded-2xl border border-slate-200 p-8">
                        <h2 class="text-2xl font-bold text-slate-900 mb-6">🔌 Integrasi API</h2>
                        
                        <div class="space-y-6">
                            <div>
                                <h3 class="font-bold text-slate-900 mb-3">Google Gemini API</h3>
                                <div class="bg-slate-50 rounded-xl p-4 border border-slate-200">
                                    <div class="flex items-center justify-between">
                                        <span class="text-slate-600">Status:</span>
                                        @if(!empty(env('GOOGLE_AI_API_KEY')))
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">✓ Aktif</span>
                                        @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">✕ Tidak Aktif</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h3 class="font-bold text-slate-900 mb-3">Midtrans Payment Gateway</h3>
                                <div class="bg-slate-50 rounded-xl p-4 border border-slate-200">
                                    <div class="flex items-center justify-between">
                                        <span class="text-slate-600">Status:</span>
                                        @if(!empty(env('MIDTRANS_SERVER_KEY')))
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">✓ Aktif</span>
                                        @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">✕ Tidak Aktif</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
