<x-brand-layout>
    <x-slot:title>Brand Partner Pricing</x-slot:title>

    @php
        $brandPlans = config('pricing.brand_plans');
        $proPlan = $brandPlans['pro'] ?? ['monthly_price' => 0, 'yearly_discount_months' => 0];
        $proMonthly = (int) ($proPlan['monthly_price'] ?? 0);
        $proYearlyDiscount = (int) ($proPlan['yearly_discount_months'] ?? 0);
        $proYearlyPayMonths = max(0, 12 - $proYearlyDiscount);
        $proYearly = $proMonthly * $proYearlyPayMonths;
    @endphp

    <div class="space-y-8">
        <div class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white rounded-3xl p-8 shadow-lg">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <p class="text-sm uppercase tracking-wide text-slate-300 font-semibold">Brand Partner Plans</p>
                    <h1 class="text-3xl md:text-4xl font-extrabold mt-2">Pilih paket untuk brand Anda</h1>
                    <p class="text-slate-200 mt-3 text-sm md:text-base">Akses analytics, banner placement, dan tools brand khusus tanpa tercampur dengan paket pengguna individu.</p>
                </div>
                <a href="mailto:sales@scanfitsolutions.com" class="inline-flex items-center gap-2 px-5 py-3 bg-white text-slate-900 rounded-xl font-bold shadow hover:bg-slate-100 transition">
                    Hubungi Sales
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex flex-col">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900">Basic</h2>
                        <p class="text-lg font-extrabold text-slate-700">Rp 0</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700">Gratis</span>
                </div>
                <p class="text-slate-500 text-sm mb-6">Cocok untuk brand yang baru mulai dan ingin mencoba dashboard.</p>
                <ul class="space-y-3 text-sm text-slate-700 flex-1">
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-emerald-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 00-1.414 0L8 12.586 4.707 9.293a1 1 0 00-1.414 1.414l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z" /></svg>
                        Total views dasar
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-emerald-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 00-1.414 0L8 12.586 4.707 9.293a1 1 0 00-1.414 1.414l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z" /></svg>
                        Banner slot terbatas
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-emerald-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 00-1.414 0L8 12.586 4.707 9.293a1 1 0 00-1.414 1.414l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z" /></svg>
                        Import produk CSV
                    </li>
                    <li class="flex items-start gap-2 text-slate-500">
                        <svg class="w-4 h-4 text-slate-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 10a7 7 0 1112.95 3.316l1.387 1.387a1 1 0 01-1.414 1.414l-1.387-1.387A7 7 0 013 10zm7-5a5 5 0 100 10A5 5 0 0010 5z" clip-rule="evenodd" /></svg>
                        Analytics detail terkunci
                    </li>
                </ul>
                <div class="mt-6">
                    <span class="inline-flex items-center px-4 py-2 rounded-xl border border-slate-200 text-slate-700 font-semibold">Paket aktif default</span>
                </div>
            </div>

            <div class="bg-white border border-indigo-200 rounded-2xl p-6 shadow-lg ring-2 ring-indigo-100 flex flex-col">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900">Pro</h2>
                        <p class="text-lg font-extrabold text-slate-900">Rp {{ number_format($proMonthly, 0, ',', '.') }} <span class="text-xs font-semibold text-slate-500">/ bulan</span></p>
                        <p class="text-xs text-slate-500">Bayar tahunan: Rp {{ number_format($proYearly, 0, ',', '.') }} (hemat {{ $proYearlyDiscount }} bln)</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-indigo-100 text-indigo-700">Rekomendasi</span>
                </div>
                <p class="text-slate-500 text-sm mb-6">Untuk brand yang membutuhkan insight penuh dan optimasi performa.</p>
                <ul class="space-y-3 text-sm text-slate-700 flex-1">
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-indigo-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 00-1.414 0L8 12.586 4.707 9.293a1 1 0 00-1.414 1.414l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z" /></svg>
                        Analytics lengkap (conversion, engagement, scan matches)
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-indigo-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 00-1.414 0L8 12.586 4.707 9.293a1 1 0 00-1.414 1.414l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z" /></svg>
                        Top products & share of traffic
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-indigo-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 00-1.414 0L8 12.586 4.707 9.293a1 1 0 00-1.414 1.414l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z" /></svg>
                        Banner placement & A/B testing
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-indigo-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 00-1.414 0L8 12.586 4.707 9.293a1 1 0 00-1.414 1.414l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z" /></svg>
                        Prioritas support & integrasi API
                    </li>
                </ul>
                <div class="mt-6 flex flex-col gap-3">
                    <form method="POST" action="{{ route('brand.subscription.upgrade') }}" class="flex flex-col gap-3">
                        @csrf
                        <input type="hidden" name="plan" value="pro">
                        <input type="hidden" name="duration" value="monthly">
                        <button type="submit" class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-bold shadow hover:from-indigo-700 hover:to-purple-700 transition">
                            Bayar Rp {{ number_format($proMonthly, 0, ',', '.') }} / bulan
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                        </button>
                    </form>
                    <p class="text-xs text-slate-500 text-center">Aktivasi Pro membuka seluruh data analytics brand Anda.</p>
                </div>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
            <h3 class="text-lg font-bold text-slate-900 mb-3">FAQ Ringkas</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-slate-700">
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                    <p class="font-semibold text-slate-900">Apakah paket brand terpisah dari user?</p>
                    <p class="mt-1 text-slate-600">Ya. Paket brand hanya untuk dashboard brand partner dan tidak mengubah langganan pengguna individu.</p>
                </div>
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                    <p class="font-semibold text-slate-900">Bagaimana mengaktifkan Pro?</p>
                    <p class="mt-1 text-slate-600">Hubungi tim sales untuk penawaran dan aktivasi paket Pro pada brand Anda.</p>
                </div>
            </div>
        </div>
    </div>
</x-brand-layout>
