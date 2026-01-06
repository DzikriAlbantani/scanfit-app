<x-layout>
    <x-slot:title>Bayar Paket</x-slot:title>

    <div class="min-h-screen bg-slate-50 pt-32 pb-20 px-4 sm:px-6 lg:px-8">
        <!-- Hero -->
        <div class="max-w-5xl mx-auto text-center mb-10">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white shadow-sm border border-slate-200 text-sm font-semibold text-slate-700">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                Pembayaran aman via Midtrans
            </div>
            <h1 class="mt-4 text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Konfirmasi Pembayaran</h1>
            <p class="mt-2 text-slate-600">Pesanan <span class="font-semibold">{{ $payment->order_id }}</span></p>
        </div>

        <div class="max-w-5xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
            <!-- Order Summary + Pay -->
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg border border-slate-200 p-6 sm:p-8 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-50 via-white to-transparent opacity-70 pointer-events-none"></div>
                <div class="relative flex flex-col gap-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div>
                            <p class="text-sm font-semibold text-emerald-600 uppercase tracking-wide">Paket {{ ucfirst($payment->plan) }}</p>
                            <p class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                            <p class="text-xs text-slate-500 mt-1">Total tagihan</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-slate-500">Order ID</p>
                            <p class="text-sm font-semibold text-slate-800">{{ $payment->order_id }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm text-slate-600">
                        <div class="flex items-center gap-2 p-3 rounded-xl bg-slate-50 border border-slate-100">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            <span>Metode: Midtrans Snap</span>
                        </div>
                        <div class="flex items-center gap-2 p-3 rounded-xl bg-slate-50 border border-slate-100">
                            <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                            <span>Langkah: Buka Snap & selesaikan</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-sm">
                        <div class="rounded-xl border border-slate-100 bg-white p-3 shadow-sm">
                            <p class="text-[11px] uppercase font-bold text-slate-500">Langkah 1</p>
                            <p class="text-slate-800 font-semibold mt-1">Tinjau nominal</p>
                        </div>
                        <div class="rounded-xl border border-slate-100 bg-white p-3 shadow-sm">
                            <p class="text-[11px] uppercase font-bold text-slate-500">Langkah 2</p>
                            <p class="text-slate-800 font-semibold mt-1">Bayar di Snap</p>
                        </div>
                        <div class="rounded-xl border border-slate-100 bg-white p-3 shadow-sm">
                            <p class="text-[11px] uppercase font-bold text-slate-500">Langkah 3</p>
                            <p class="text-slate-800 font-semibold mt-1">Aktivasi otomatis</p>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3">
                        <button id="pay-button" class="w-full py-4 rounded-xl bg-gradient-to-r from-emerald-600 to-green-600 text-white font-bold shadow-lg hover:shadow-xl transition-transform duration-200 hover:-translate-y-0.5">
                            Bayar Sekarang
                        </button>
                        <p class="text-xs text-slate-500 text-center">Anda akan diarahkan ke Midtrans Snap. Jangan tutup jendela hingga pembayaran selesai.</p>
                    </div>
                </div>
            </div>

            <!-- Tips / Support -->
            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6 sm:p-7 flex flex-col gap-5">
                <div>
                    <p class="text-sm font-bold text-slate-900">Keamanan Transaksi</p>
                    <p class="text-sm text-slate-600 mt-2">Pembayaran diproses aman oleh Midtrans. Data kartu Anda tidak disimpan di sistem kami.</p>
                </div>
                <div class="space-y-3 text-sm text-slate-700">
                    <div class="flex gap-2">
                        <span class="text-emerald-500 mt-0.5">•</span>
                        <span>Pilih metode pembayaran favorit di Snap (VA, e-wallet, kartu).</span>
                    </div>
                    <div class="flex gap-2">
                        <span class="text-emerald-500 mt-0.5">•</span>
                        <span>Jika ditutup sebelum selesai, buka kembali dan klik Bayar untuk melanjutkan.</span>
                    </div>
                    <div class="flex gap-2">
                        <span class="text-emerald-500 mt-0.5">•</span>
                        <span>Butuh bantuan? Hubungi support setelah 5 menit bila status belum berubah.</span>
                    </div>
                </div>
                <div class="pt-2">
                    <a href="{{ ($payment->metadata['brand_subscription'] ?? false) ? route('brand.pricing') : route('pricing.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-700 hover:text-slate-900">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        Kembali ke Pricing
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="https://app{{ config('midtrans.is_production') ? '' : '.sandbox' }}.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script>
    <script>
        document.getElementById('pay-button').addEventListener('click', function () {
            window.snap.pay("{{ $snapToken }}", {
                onSuccess: function (result) {
                    // Redirect to success page with payment ID
                    window.location.href = "{{ route('payments.success', $payment->id) }}";
                },
                onPending: function (result) {
                    window.location.href = "{{ route('payments.success', $payment->id) }}";
                },
                onError: function (result) {
                    alert('Pembayaran gagal. Silakan coba lagi.');
                },
                onClose: function () {
                    console.log('Snap closed without finishing payment');
                }
            });
        });
    </script>
</x-layout>
