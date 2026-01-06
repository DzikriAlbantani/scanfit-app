@php
    $info = auth()->user()->getSubscriptionInfo();
    $isActive = $info['is_active'];
@endphp

<div class="max-w-4xl mx-auto py-12">
    <h1 class="text-3xl font-bold mb-2">Paket Langganan</h1>
    <p class="text-slate-600 mb-8">Kelola paket berlangganan dan benefit Anda.</p>

    @if($isActive)
    <div class="grid md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-2xl border p-6">
            <p class="text-sm text-slate-600 font-bold uppercase">Paket Aktif</p>
            <p class="text-3xl font-bold text-slate-900 mt-2">{{ $info['name'] }}</p>
        </div>
        <div class="bg-white rounded-2xl border p-6">
            <p class="text-sm text-slate-600 font-bold uppercase">Berlaku Hingga</p>
            <p class="text-2xl font-bold text-slate-900 mt-2">{{ $info['expires_at']->translatedFormat('d M Y') }}</p>
            <p class="text-xs text-slate-600 mt-2">
                @php
                    $daysLeft = now()->diffInDays($info['expires_at']);
                @endphp
                {{ $daysLeft }} hari lagi
            </p>
        </div>
        <div class="bg-white rounded-2xl border p-6">
            <p class="text-sm text-slate-600 font-bold uppercase">Status</p>
            <p class="text-lg font-bold text-emerald-600 mt-2">✓ Aktif</p>
            <a href="{{ route('pricing.index') }}" class="text-xs text-slate-600 hover:underline mt-3 block">Upgrade atau Tambah Hari →</a>
        </div>
    </div>

    <!-- Benefits -->
    <div class="bg-white rounded-2xl border p-8 mb-8">
        <h2 class="text-xl font-bold mb-6">Benefit Paket {{ $info['name'] }}</h2>
        <div class="grid md:grid-cols-2 gap-6">
            @foreach($info['features'] as $key => $value)
                <div class="flex items-start gap-3">
                    <span class="text-emerald-600 text-xl mt-1">✓</span>
                    <div>
                        <p class="font-bold capitalize text-slate-900">
                            {{ str_replace('_', ' ', $key) }}
                        </p>
                        @if(is_numeric($value))
                            <p class="text-sm text-slate-600">Hingga {{ $value }} per bulan</p>
                        @elseif($value === 'unlimited')
                            <p class="text-sm text-slate-600">Unlimited</p>
                        @elseif($value === true)
                            <p class="text-sm text-slate-600">Tersedia</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @else
    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-8 mb-8">
        <h2 class="text-xl font-bold text-amber-900 mb-2">Paket Berakhir</h2>
        <p class="text-amber-800 mb-4">Paket langganan Anda telah berakhir pada {{ $info['expires_at']->translatedFormat('d M Y') }}.</p>
        <a href="{{ route('pricing.index') }}" class="inline-block px-6 py-3 bg-amber-600 text-white rounded-lg font-bold hover:bg-amber-700">
            Perpanjang atau Upgrade Paket
        </a>
    </div>

    <!-- Last Active Benefits -->
    @if(count($info['features']) > 0)
    <div class="bg-white rounded-2xl border p-8">
        <h2 class="text-xl font-bold mb-4">Benefit Terakhir ({{ $info['name'] }})</h2>
        <ul class="space-y-3 text-slate-700">
            @foreach($info['features'] as $key => $value)
                <li class="flex items-center gap-2">
                    <span class="text-slate-400">•</span> {{ str_replace('_', ' ', $key) }}
                </li>
            @endforeach
        </ul>
    </div>
    @endif
    @endif

    <!-- Current Usage -->
    <div class="bg-white rounded-2xl border p-8 mt-8">
        <h2 class="text-xl font-bold mb-6">Penggunaan Bulan Ini</h2>
        <div class="grid md:grid-cols-3 gap-6">
            <div>
                <p class="text-sm text-slate-600 font-bold uppercase mb-2">Scan</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-slate-900">{{ auth()->user()->scan_count_monthly ?? 0 }}</span>
                    <span class="text-slate-600">
                        @php
                            $limit = $info['features']['scans_per_month'] ?? 10;
                            $display = is_numeric($limit) ? (int)$limit : 'unlimited';
                        @endphp
                        / {{ $display }}
                    </span>
                </div>
            </div>
            <div>
                <p class="text-sm text-slate-600 font-bold uppercase mb-2">Items Closet</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-slate-900">{{ auth()->user()->closetItems()->count() }}</span>
                    <span class="text-slate-600">
                        @php
                            $limit = $info['features']['closet_items'] ?? 15;
                            $display = is_numeric($limit) ? (int)$limit : 'unlimited';
                        @endphp
                        / {{ $display }}
                    </span>
                </div>
            </div>
            <div>
                <p class="text-sm text-slate-600 font-bold uppercase mb-2">Album</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-slate-900">{{ auth()->user()->albums()->count() }}</span>
                    <span class="text-slate-600">
                        @php
                            $limit = $info['features']['albums'] ?? 3;
                            $display = is_numeric($limit) ? (int)$limit : 'unlimited';
                        @endphp
                        / {{ $display }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
