<x-layout>
    <x-slot:title>Upgrade ke Premium</x-slot:title>

    <div class="min-h-screen bg-slate-50" x-data="{ cycle: 'monthly' }">
        <!-- Hero Section -->
            <section class="relative overflow-hidden bg-gradient-to-br from-slate-900 via-slate-900/95 to-slate-800 pt-48 pb-32 border-b border-slate-700">
            <!-- Gradient blur elements -->
            <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-indigo-500/20 rounded-full blur-3xl opacity-40 -mr-40 -mt-40 pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-purple-500/20 rounded-full blur-3xl opacity-40 -ml-40 mb-0 pointer-events-none"></div>
            
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center mb-12 space-y-4">
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-white text-xs font-semibold hover:bg-white/15 transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2l2.39 4.84 5.34.78-3.86 3.76.91 5.31L10 14.77 4.22 16.69l.91-5.31L1.27 7.62l5.34-.78L10 2z"/></svg>
                        Buka Potensi Penuh
                    </span>
                    
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white">
                        Upgrade ke <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400">Premium</span>
                    </h1>
                    
                    <p class="text-lg sm:text-xl text-slate-300 max-w-2xl mx-auto leading-relaxed">
                        Dapatkan akses unlimited ke AI scanning, personalized recommendations, dan analytics mendalam untuk gaya yang lebih sempurna.
                    </p>
                </div>

                <!-- Pricing Toggle -->
                <div class="flex justify-center">
                    <div class="inline-flex items-center rounded-full bg-white/10 backdrop-blur-md border border-white/20 p-1.5 shadow-xl">
                        <button type="button" 
                                @click="cycle='monthly'" 
                                :class="cycle==='monthly' ? 'bg-white text-slate-900' : 'text-white hover:bg-white/5'" 
                                class="px-6 py-2.5 rounded-full text-sm font-bold transition duration-300">
                            Bulanan
                        </button>
                        <button type="button" 
                                @click="cycle='yearly'" 
                                :class="cycle==='yearly' ? 'bg-white text-slate-900' : 'text-white hover:bg-white/5'" 
                                class="px-6 py-2.5 rounded-full text-sm font-bold transition duration-300">
                            Tahunan
                            <span class="ml-2 inline-block px-2 py-1 bg-green-500/30 text-green-300 text-xs font-bold rounded border border-green-400/50">Hemat 20%</span>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Pricing Cards Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 pb-24 relative z-20">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6">
            @php
                $plans = config('pricing.plans');
                $plusMonthly = (int)($plans['plus']['monthly_price'] ?? 49000);
                $plusDiscountMonths = (int)($plans['plus']['yearly_discount_months'] ?? 2);
                $plusYearly = $plusMonthly * max(0, 12 - $plusDiscountMonths);
                $proMonthly = (int)($plans['pro']['monthly_price'] ?? 99000);
                $proDiscountMonths = (int)($plans['pro']['yearly_discount_months'] ?? 2);
                $proYearly = $proMonthly * max(0, 12 - $proDiscountMonths);
            @endphp

             <!-- Basic -->
                    <div class="absolute inset-0 bg-gradient-to-br from-slate-50 to-transparent opacity-0 group-hover:opacity-100 rounded-2xl transition-opacity pointer-events-none"></div>
                    
                    <div class="relative mb-6">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-bold mb-3">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/></svg>
                            Untuk Pemula
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 mb-3">Basic</h3>
                        <div class="flex items-baseline gap-1">
                            <span class="text-4xl font-extrabold text-slate-900">Gratis</span>
                        </div>
                        <p class="text-sm text-slate-500 mt-2">Akses dasar untuk memulai</p>
                    </div>

                    <ul class="space-y-3 text-sm text-slate-600 flex-grow mb-8">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 00-1.414 0L8 12.586 4.707 9.293a1 1 0 00-1.414 1.414l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z"/></svg>
                            <span>10 Scan/bulan</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 00-1.414 0L8 12.586 4.707 9.293a1 1 0 00-1.414 1.414l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z"/></svg>
                            <span>15 Closet Items</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 00-1.414 0L8 12.586 4.707 9.293a1 1 0 00-1.414 1.414l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z"/></svg>
                            <span>Rekomendasi standar</span>
                        </li>
                    </ul>
                    
                    <form method="POST" action="{{ route('subscription.upgrade', 'basic') }}" class="relative">@csrf
                        <button class="w-full px-6 py-3 rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-50 font-bold transition-all duration-300">Pilih Basic</button>
                    </form>
                </div>

                <!-- Plus - Most Popular -->
                @php $currentPlan = strtolower($user?->subscription_plan ?? 'basic'); @endphp
                <div class="group relative bg-white rounded-2xl p-6 sm:p-8 shadow-xl border-2 {{ $currentPlan==='plus' ? 'border-indigo-500 ring-4 ring-indigo-100' : 'border-indigo-200' }} hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 flex flex-col md:transform md:scale-105 md:z-10">
                    <div class="absolute -top-4 right-6">
                        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-gradient-to-r from-indigo-500 to-purple-600 text-white text-xs font-bold shadow-lg">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            PALING POPULER
                        </div>
                    </div>

                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-50/50 to-transparent opacity-0 group-hover:opacity-100 rounded-2xl transition-opacity pointer-events-none"></div>

                    <div class="relative mb-6">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold mb-3">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 6H6.28l-.31-1.243A1 1 0 005 4H3z"/></svg>
                            Untuk Aktif
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 mb-3">Plus</h3>
                        <div class="flex items-baseline gap-2">
                            <div x-show="cycle==='monthly'" class="flex items-baseline gap-1">
                                <span class="text-4xl font-extrabold text-slate-900">Rp {{ number_format($plusMonthly, 0, ',', '.') }}</span>
                                <span class="text-sm font-semibold text-slate-500">/bulan</span>
                            </div>
                            <div x-show="cycle==='yearly'" class="flex items-baseline gap-1">
                                <span class="text-4xl font-extrabold text-slate-900">Rp {{ number_format($plusYearly, 0, ',', '.') }}</span>
                                <span class="text-sm font-semibold text-slate-500">/tahun</span>
                            </div>
                        </div>
                        @if($plusDiscountMonths>0)
                        <div x-show="cycle==='yearly'" class="mt-3 inline-flex items-center px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold">
                            <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"/></svg>
                            Hemat {{ $plusDiscountMonths }} bulan
                        </div>
                        @endif
                        <p class="text-sm text-slate-500 mt-2">Pilihan terbaik untuk penggunaan rutin</p>
                    </div>

                    <ul class="space-y-3 text-sm text-slate-600 flex-grow mb-8">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-indigo-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 00-1.414 0L8 12.586 4.707 9.293a1 1 0 00-1.414 1.414l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z"/></svg>
                            <span>50 Scan/bulan</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-indigo-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 00-1.414 0L8 12.586 4.707 9.293a1 1 0 00-1.414 1.414l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z"/></svg>
                            <span>100 Closet Items</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-indigo-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 00-1.414 0L8 12.586 4.707 9.293a1 1 0 00-1.414 1.414l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z"/></svg>
                            <span>Rekomendasi dipersonalisasi</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-indigo-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 00-1.414 0L8 12.586 4.707 9.293a1 1 0 00-1.414 1.414l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z"/></svg>
                            <span>Prioritas pemrosesan</span>
                        </li>
                    </ul>

                    @if($currentPlan==='plus')
                        <span class="relative w-full px-6 py-3 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200 font-bold text-center">Paket Aktif Anda</span>
                    @else
                        <a :href="'{{ route('payments.checkout', 'plus') }}?cycle=' + cycle" class="relative w-full px-6 py-3 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold text-center shadow-lg hover:shadow-xl transition-all duration-300 group/btn">
                            <span class="flex items-center justify-center gap-2">
                                Pilih Plus
                                <svg class="w-4 h-4 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                            </span>
                        </a>
                    @endif
                </div>

                <!-- Pro -->
                <div class="group relative bg-white rounded-2xl p-6 sm:p-8 shadow-lg border border-slate-200 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 flex flex-col">
                    <div class="absolute -top-4 right-6">
                        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-gradient-to-r from-amber-500 to-orange-600 text-white text-xs font-bold shadow-lg">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            UNLIMITED
                        </div>
                    </div>

                    <div class="absolute inset-0 bg-gradient-to-br from-amber-50/50 to-transparent opacity-0 group-hover:opacity-100 rounded-2xl transition-opacity pointer-events-none"></div>

                    <div class="relative mb-6">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-bold mb-3">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            Untuk Pro
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 mb-3">Pro</h3>
                        <div class="flex items-baseline gap-2">
                            <div x-show="cycle==='monthly'" class="flex items-baseline gap-1">
                                <span class="text-4xl font-extrabold text-slate-900">Rp {{ number_format($proMonthly, 0, ',', '.') }}</span>
                                <span class="text-sm font-semibold text-slate-500">/bulan</span>
                            </div>
                            <div x-show="cycle==='yearly'" class="flex items-baseline gap-1">
                                <span class="text-4xl font-extrabold text-slate-900">Rp {{ number_format($proYearly, 0, ',', '.') }}</span>
                                <span class="text-sm font-semibold text-slate-500">/tahun</span>
                            </div>
                        </div>
                        @if($proDiscountMonths>0)
                        <div x-show="cycle==='yearly'" class="mt-3 inline-flex items-center px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold">
                            <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"/></svg>
                            Hemat {{ $proDiscountMonths }} bulan
                        </div>
                        @endif
                        <p class="text-sm text-slate-500 mt-2">Untuk hasil maksimal & performa terbaik</p>
                    </div>

                    <ul class="space-y-3 text-sm text-slate-600 flex-grow mb-8">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 00-1.414 0L8 12.586 4.707 9.293a1 1 0 00-1.414 1.414l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z"/></svg>
                            <span>Scan tanpa batas</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 00-1.414 0L8 12.586 4.707 9.293a1 1 0 00-1.414 1.414l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z"/></svg>
                            <span>Closet tanpa batas</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 00-1.414 0L8 12.586 4.707 9.293a1 1 0 00-1.414 1.414l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z"/></svg>
                            <span>Analisis & rekomendasi pro</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 00-1.414 0L8 12.586 4.707 9.293a1 1 0 00-1.414 1.414l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z"/></svg>
                            <span>Dukungan prioritas 24/7</span>
                        </li>
                    </ul>

                    @if($currentPlan==='pro')
                        <span class="relative w-full px-6 py-3 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200 font-bold text-center">Paket Aktif Anda</span>
                    @else
                        <a :href="'{{ route('payments.checkout', 'pro') }}?cycle=' + cycle" class="relative w-full px-6 py-3 rounded-xl bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-bold text-center shadow-lg hover:shadow-xl transition-all duration-300 group/btn">
                            <span class="flex items-center justify-center gap-2">
                                Pilih Pro
                                <svg class="w-4 h-4 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                            </span>
                        </a>
                    @endif
                </div>

            <!-- CTA Section -->
            <div class="mt-20 text-center">
                @if(($user?->isPremium()))
                    <a href="{{ route('scan.index') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-slate-900 to-slate-800 hover:from-slate-800 hover:to-slate-700 text-white rounded-xl font-bold shadow-lg hover:shadow-xl transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Mulai Scan Sekarang
                    </a>
                @else
                    <div class="inline-block text-center p-6 bg-slate-900/5 rounded-2xl border border-slate-200">
                        <p class="text-sm text-slate-600 mb-2">Saat ini paket Anda:</p>
                        <p class="text-xl font-bold text-slate-900">{{ ucfirst($user?->subscription_plan ?? 'basic') }}</p>
                    </div>
                @endif
                </div>
        </div>

        <!-- Features Section -->
        <section class="bg-white border-t border-slate-200">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                <div class="text-center mb-12">
                    <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 mb-4">Fitur Unggulan Premium</h2>
                    <p class="text-lg text-slate-600">Tingkatkan pengalaman styling dengan tools canggih kami</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="relative group">
                        <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/10 to-purple-500/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="relative p-6 rounded-2xl border border-slate-200 group-hover:border-indigo-200 transition-colors">
                            <div class="w-12 h-12 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-xl flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 mb-2">AI Scanning Ultra Cepat</h3>
                            <p class="text-slate-600">Teknologi AI terdepan untuk identifikasi pakaian dan rekomendasi styling dalam hitungan detik.</p>
                        </div>
                    </div>

                    <!-- Feature 2 -->
                    <div class="relative group">
                        <div class="absolute inset-0 bg-gradient-to-br from-purple-500/10 to-pink-500/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="relative p-6 rounded-2xl border border-slate-200 group-hover:border-purple-200 transition-colors">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-600 to-pink-600 rounded-xl flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.5a2 2 0 00-1 .268V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v10.268A2 2 0 003.5 13H1a2 2 0 00-2 2v4a2 2 0 002 2h12z"/></svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 mb-2">Rekomendasi Dipersonalisasi</h3>
                            <p class="text-slate-600">Dapatkan saran outfit yang disesuaikan dengan gaya, preferensi warna, dan body type Anda.</p>
                        </div>
                    </div>

                    <!-- Feature 3 -->
                    <div class="relative group">
                        <div class="absolute inset-0 bg-gradient-to-br from-amber-500/10 to-orange-500/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="relative p-6 rounded-2xl border border-slate-200 group-hover:border-amber-200 transition-colors">
                            <div class="w-12 h-12 bg-gradient-to-br from-amber-600 to-orange-600 rounded-xl flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 mb-2">Analytics Mendalam</h3>
                            <p class="text-slate-600">Analisis tren gaya Anda, preferensi warna yang sering dipakai, dan insight fashion personal.</p>
                        </div>
                    </div>

                    <!-- Feature 4 -->
                    <div class="relative group">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 to-cyan-500/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="relative p-6 rounded-2xl border border-slate-200 group-hover:border-blue-200 transition-colors">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-cyan-600 rounded-xl flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h6a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V5z"/></svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 mb-2">Virtual Closet Premium</h3>
                            <p class="text-slate-600">Kelola koleksi pakaian Anda dengan tags, categories, dan riwayat pemakaian yang terorganisir.</p>
                        </div>
                    </div>

                    <!-- Feature 5 -->
                    <div class="relative group">
                        <div class="absolute inset-0 bg-gradient-to-br from-green-500/10 to-emerald-500/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="relative p-6 rounded-2xl border border-slate-200 group-hover:border-green-200 transition-colors">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-600 to-emerald-600 rounded-xl flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1m2-1v2.5M4 7l2 1m-2-1l2-1m-2 1v2.5"/></svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 mb-2">Kolaborasi & Sharing</h3>
                            <p class="text-slate-600">Bagikan outfit dengan teman, dapatkan feedback, dan temukan inspirasi dari komunitas.</p>
                        </div>
                    </div>

                    <!-- Feature 6 -->
                    <div class="relative group">
                        <div class="absolute inset-0 bg-gradient-to-br from-rose-500/10 to-pink-500/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="relative p-6 rounded-2xl border border-slate-200 group-hover:border-rose-200 transition-colors">
                            <div class="w-12 h-12 bg-gradient-to-br from-rose-600 to-pink-600 rounded-xl flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 mb-2">Akses Diskon Eksklusif</h3>
                            <p class="text-slate-600">Dapatkan notifikasi sale dari brand favorit Anda dengan potongan harga khusus member.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ Section -->
        <section class="bg-gradient-to-br from-slate-50 to-slate-100 border-t border-slate-200">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                <div class="text-center mb-12">
                    <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 mb-4">Pertanyaan Umum</h2>
                    <p class="text-lg text-slate-600">Semua yang perlu Anda ketahui tentang paket premium kami</p>
                </div>

                <div class="space-y-4">
                    <details class="group bg-white rounded-xl border border-slate-200 hover:border-indigo-200 hover:shadow-md transition-all p-6 cursor-pointer">
                        <summary class="flex items-center justify-between font-bold text-slate-900 text-lg">
                            <span>Bisakah saya upgrade atau downgrade kapan saja?</span>
                            <svg class="w-5 h-5 text-slate-600 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                        </summary>
                        <p class="text-slate-600 mt-4">Ya! Anda dapat mengubah paket kapan saja. Perubahan akan berlaku di periode billing berikutnya tanpa biaya tambahan.</p>
                    </details>

                    <details class="group bg-white rounded-xl border border-slate-200 hover:border-indigo-200 hover:shadow-md transition-all p-6 cursor-pointer">
                        <summary class="flex items-center justify-between font-bold text-slate-900 text-lg">
                            <span>Apa yang terjadi jika saya membatalkan paket?</span>
                            <svg class="w-5 h-5 text-slate-600 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                        </summary>
                        <p class="text-slate-600 mt-4">Akun Anda akan berubah ke paket Basic. Anda tetap dapat mengakses closet dan history, tapi fitur premium akan terbatas.</p>
                    </details>

                    <details class="group bg-white rounded-xl border border-slate-200 hover:border-indigo-200 hover:shadow-md transition-all p-6 cursor-pointer">
                        <summary class="flex items-center justify-between font-bold text-slate-900 text-lg">
                            <span>Apakah ada jaminan uang kembali?</span>
                            <svg class="w-5 h-5 text-slate-600 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                        </summary>
                        <p class="text-slate-600 mt-4">Ya! Kami menawarkan garansi 7 hari uang kembali jika Anda tidak puas dengan paket premium kami.</p>
                    </details>

                    <details class="group bg-white rounded-xl border border-slate-200 hover:border-indigo-200 hover:shadow-md transition-all p-6 cursor-pointer">
                        <summary class="flex items-center justify-between font-bold text-slate-900 text-lg">
                            <span>Bagaimana cara pembayaran?</span>
                            <svg class="w-5 h-5 text-slate-600 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                        </summary>
                        <p class="text-slate-600 mt-4">Kami menerima pembayaran melalui Midtrans dengan berbagai metode: kartu kredit, transfer bank, e-wallet, dan BNPL.</p>
                    </details>
                </div>
            </div>
        </section>
    </div>
</x-layout>
