<x-layout>
    <x-slot:title>Pembayaran Berhasil</x-slot:title>

    <div class="min-h-screen bg-gradient-to-br from-emerald-50 via-white to-blue-50 pt-32 pb-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto text-center">
            <!-- Success Icon -->
            <div class="mb-8 flex justify-center">
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-emerald-400 to-green-400 rounded-full blur-2xl opacity-50"></div>
                    <div class="relative w-20 h-20 bg-gradient-to-r from-emerald-500 to-green-500 rounded-full flex items-center justify-center shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Main Message -->
            <h1 class="text-4xl sm:text-5xl font-extrabold text-slate-900 tracking-tight">Selamat!</h1>
            <p class="mt-3 text-xl text-slate-600">Pembayaran Anda berhasil diproses</p>

            <!-- Plan Info Card -->
            <div class="mt-8 bg-white rounded-2xl shadow-xl border border-slate-200 p-8 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-50 to-transparent opacity-50 pointer-events-none"></div>
                <div class="relative">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-sm font-semibold text-emerald-700 mb-4">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        Paket Aktif
                    </div>

                    <p class="text-lg text-slate-600 mt-4">Anda sekarang menggunakan paket</p>
                    <p class="text-4xl font-extrabold text-slate-900 mt-2 capitalize">{{ $payment->plan ?? 'Premium' }}</p>

                    @php
                        $cycle = $payment->metadata['cycle'] ?? 'monthly';
                        $expiryDate = $cycle === 'yearly' ? now()->addYear() : now()->addMonth();
                    @endphp
                    
                    <p class="mt-6 text-sm text-slate-600">Berlaku hingga</p>
                    <p class="text-2xl font-bold text-emerald-600 mt-1">
                        {{ $expiryDate->format('d M Y') }}
                    </p>

                    <!-- Benefits -->
                    <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-4">
                        @if($payment->plan === 'plus')
                            <div class="rounded-xl bg-slate-50 border border-slate-200 p-4">
                                <p class="text-2xl font-bold text-slate-900">50</p>
                                <p class="text-sm text-slate-600 mt-1">Scan/bulan</p>
                            </div>
                            <div class="rounded-xl bg-slate-50 border border-slate-200 p-4">
                                <p class="text-2xl font-bold text-slate-900">100</p>
                                <p class="text-sm text-slate-600 mt-1">Item Closet</p>
                            </div>
                            <div class="rounded-xl bg-slate-50 border border-slate-200 p-4">
                                <p class="text-2xl font-bold text-slate-900">5</p>
                                <p class="text-sm text-slate-600 mt-1">Album</p>
                            </div>
                        @elseif($payment->plan === 'pro')
                            <div class="rounded-xl bg-slate-50 border border-slate-200 p-4">
                                <p class="text-2xl font-bold text-slate-900">∞</p>
                                <p class="text-sm text-slate-600 mt-1">Scan/bulan</p>
                            </div>
                            <div class="rounded-xl bg-slate-50 border border-slate-200 p-4">
                                <p class="text-2xl font-bold text-slate-900">∞</p>
                                <p class="text-sm text-slate-600 mt-1">Item Closet</p>
                            </div>
                            <div class="rounded-xl bg-slate-50 border border-slate-200 p-4">
                                <p class="text-2xl font-bold text-slate-900">∞</p>
                                <p class="text-sm text-slate-600 mt-1">Album</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Order Details -->
            <div class="mt-8 bg-slate-50 rounded-xl border border-slate-200 p-6">
                <h3 class="font-semibold text-slate-900">Detail Pesanan</h3>
                <div class="mt-4 space-y-3 text-sm">
                    <div class="flex justify-between items-center">
                        <span class="text-slate-600">Order ID</span>
                        <span class="font-mono font-semibold text-slate-900">{{ $payment->order_id }}</span>
                    </div>
                    <div class="h-px bg-slate-200"></div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-600">Jumlah Pembayaran</span>
                        <span class="font-semibold text-slate-900">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="h-px bg-slate-200"></div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-600">Status</span>
                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 font-semibold text-xs">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            Selesai
                        </span>
                    </div>
                </div>
            </div>

            <!-- Call to Action -->
            <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('scan.index') }}" class="px-8 py-3 rounded-xl bg-gradient-to-r from-emerald-600 to-green-600 text-white font-bold shadow-lg hover:shadow-xl transition-all duration-200 hover:-translate-y-0.5">
                    Mulai Scanning
                </a>
                <a href="{{ route('pricing.index') }}" class="px-8 py-3 rounded-xl bg-white border border-slate-300 text-slate-900 font-bold shadow-sm hover:bg-slate-50 transition-all duration-200">
                    Lihat Paket
                </a>
            </div>

            <!-- Support Note -->
            <div class="mt-10 p-6 rounded-xl bg-blue-50 border border-blue-200">
                <p class="text-sm text-blue-900">
                    <span class="font-semibold">💡 Tips:</span> Sistem kami sedang memproses pembayaran Anda. Halaman akan otomatis refresh dalam beberapa detik. Jika tidak, silakan refresh manual atau logout & login kembali.
                </p>
            </div>
        </div>
    </div>

    <script>
        let checkCount = 0;
        let subscriptionUpdated = false;
        
        async function checkSubscriptionUpdate() {
            try {
                const response = await fetch('{{ route("payments.refresh-subscription") }}', {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });
                
                if (response.ok) {
                    const data = await response.json();
                    console.log('✅ Subscription check response:', data);
                    
                    if (data.is_premium) {
                        console.log('🎉 User is now Premium!', data);
                        subscriptionUpdated = true;
                        return true;
                    } else {
                        console.log('⏳ Still waiting for payment processing...', {
                            plan: data.subscription_plan,
                            payment_status: data.payment_status,
                            payment_plan: data.payment_plan
                        });
                    }
                } else {
                    console.error('Subscription check failed:', response.status);
                }
            } catch (error) {
                console.error('❌ Error checking subscription:', error);
            }
            return false;
        }
        
        async function checkAndRefresh() {
            checkCount++;
            console.log(`📍 Check attempt ${checkCount}/3`);
            
            if (!subscriptionUpdated && checkCount <= 3) {
                // Check subscription status
                const updated = await checkSubscriptionUpdate();
                
                if (updated) {
                    console.log('🔄 Subscription updated! Reloading page...');
                    setTimeout(() => {
                        window.location.reload();
                    }, 500);
                } else {
                    // Wait 2 seconds and try again
                    setTimeout(() => {
                        checkAndRefresh();
                    }, 2000);
                }
            } else if (checkCount > 3) {
                // After 3 checks (6 seconds), force reload to get fresh data
                console.log('⏱️ Max checks reached, forcing page reload...');
                window.location.reload();
            }
        }
        
        // Start checking
        console.log('🚀 Starting subscription status checks...');
        checkAndRefresh();
    </script>
</x-layout>
