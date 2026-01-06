<x-layout>
    <div class="max-w-4xl mx-auto py-12">
        <h1 class="text-2xl font-bold mb-6">Penayangan Berbayar Banner</h1>

        <div class="bg-white rounded-2xl border p-6">
            <div class="flex items-center gap-4 mb-6">
                <img src="{{ asset('storage/' . $banner->banner_image_url) }}" alt="Banner" class="w-48 h-16 object-cover rounded-lg border">
                <div>
                    <p class="font-bold">{{ $banner->title }}</p>
                    <p class="text-sm text-slate-600">Biaya per hari: <span class="font-bold text-slate-900">Rp {{ number_format($dailyFee) }}</span></p>
                </div>
            </div>

            @if(empty($snapToken))
            <form action="{{ route('brand.bannerPlacements.store', $banner) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium mb-1">Tanggal mulai</label>
                    <input type="date" name="start_date" class="w-full border rounded-lg px-3 py-2" value="{{ now()->toDateString() }}" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Jumlah hari</label>
                    <input type="number" name="days" class="w-full border rounded-lg px-3 py-2" min="1" max="365" value="7" required>
                </div>
                <button class="px-5 py-3 bg-slate-900 text-white rounded-lg font-bold">Lanjutkan Pembayaran</button>
            </form>
            @else
            <div class="space-y-4">
                <p>Silakan lanjutkan pembayaran untuk mengaktifkan penayangan.</p>
                <button id="pay-button" class="px-5 py-3 bg-emerald-600 text-white rounded-lg font-bold">Bayar Sekarang</button>
                <p class="text-sm text-slate-600">Jika jendela pembayaran tidak muncul, pastikan pop-up tidak diblokir.</p>
            </div>
            <script type="text/javascript" src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script>
            <script>
                document.getElementById('pay-button').addEventListener('click', function () {
                    window.snap.pay('{{ $snapToken }}', {
                        onSuccess: function(result){ window.location.href = '{{ route('brand.bannerPlacements.finish', [$banner->id, $placement->id]) }}'; },
                        onPending: function(result){ window.location.href = '{{ route('brand.bannerPlacements.finish', [$banner->id, $placement->id]) }}'; },
                        onError: function(result){ alert('Pembayaran gagal'); },
                        onClose: function(){ alert('Jendela pembayaran ditutup sebelum selesai'); }
                    });
                });
            </script>
            @endif
        </div>
    </div>
</x-layout>
