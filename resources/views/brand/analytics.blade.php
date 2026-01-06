<x-brand-layout>
    <x-slot:title>Analytics - ScanFit Brand</x-slot:title>

    @php
        $isPro = $analytics['is_pro'] ?? true;
    @endphp

    {{-- Header Section with Refresh Button --}}
    <div class="mb-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Analytics Overview</h1>
            <p class="text-slate-500">Track your brand performance and user engagement insights. Real-time data updated every 30 seconds.</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $isPro ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-700 border border-slate-200' }}">
                Plan: {{ strtoupper($analytics['subscription_plan'] ?? ($isPro ? 'pro' : 'basic')) }}
            </span>
            @if(!$isPro)
                <a href="{{ route('brand.pricing') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg shadow-sm hover:from-blue-700 hover:to-indigo-700 transition-colors font-medium text-sm">
                    Upgrade to Pro
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                </a>
            @endif
            <button id="refreshBtn" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium text-sm">
                <svg id="refreshIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                <span id="refreshText">Refresh</span>
            </button>
        </div>
    </div>

    @if(!$isPro)
        <div class="mb-6 p-4 bg-slate-900 text-white rounded-2xl flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <div>
                <p class="text-sm font-semibold">Analytics Pro Locked</p>
                <p class="text-xs text-slate-200">Total views tetap terlihat. Insight detail, chart, dan top products tersedia setelah upgrade.</p>
            </div>
            <a href="{{ route('brand.pricing') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-slate-900 rounded-lg font-bold text-sm hover:bg-slate-100">
                Lihat Paket Pro
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
            </a>
        </div>
    @endif

    {{-- Stats Grid (30 hari terakhir, data nyata) --}}
    @php
        $deltaViews = $analytics['deltas']['views'] ?? null;
        $deltaConversion = $analytics['deltas']['conversion'] ?? null;
        $deltaEngagement = $analytics['deltas']['engagement'] ?? null;
        $newProducts = $analytics['deltas']['new_products'] ?? 0;

        $badge = function($delta) {
            if ($delta === null) return ['label' => 'New data', 'class' => 'text-slate-600 bg-slate-100'];
            $isUp = $delta >= 0;
            $class = $isUp ? 'text-green-600 bg-green-50' : 'text-red-600 bg-red-50';
            $icon = $isUp ? 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6' : 'M13 17h8m0 0V9m0 8l-8-8-4 4-6-6';
            $label = ($isUp ? '+' : '') . $delta . '% vs prev 30d';
            return compact('label','class','icon');
        };
        $badgeViews = $badge($deltaViews);
        $badgeConversion = $badge($deltaConversion);
        $badgeEngagement = $badge($deltaEngagement);
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8" id="statsGrid">
        {{-- Active Products --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 relative overflow-hidden {{ $isPro ? '' : 'opacity-60' }}">
            <div class="absolute top-4 right-4 w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            </div>
            <div class="pr-16">
                <p class="text-sm font-medium text-slate-500 mb-1">Active Products</p>
                @if($isPro)
                    <p class="text-3xl font-bold text-slate-900" data-metric="active_products">{{ number_format($analytics['active_products']) }}</p>
                    <div class="flex items-center mt-2 text-xs font-medium text-indigo-700 bg-indigo-50 px-2 py-1 rounded-full w-fit">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        <span data-metric="new_products">{{ $newProducts }}</span> new in 30d
                    </div>
                @else
                    <p class="text-3xl font-bold text-slate-900">Locked</p>
                    <div class="mt-2 inline-flex items-center text-xs font-semibold text-slate-600 bg-slate-100 px-2 py-1 rounded-full">Upgrade to view</div>
                @endif
            </div>
            @if(!$isPro)
                <div class="absolute inset-0 bg-white/70 backdrop-blur-sm"></div>
            @endif
        </div>

        {{-- Conversion Rate --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 relative overflow-hidden {{ $isPro ? '' : 'opacity-60' }}">
            <div class="absolute top-4 right-4 w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
            </div>
            <div class="pr-16">
                <p class="text-sm font-medium text-slate-500 mb-1">Conversion Rate</p>
                @if($isPro)
                    <p class="text-3xl font-bold text-slate-900" data-metric="conversion_rate">{{ number_format($analytics['conversion_rate'], 1) }}%</p>
                    <div class="flex items-center mt-2 text-xs font-medium px-2 py-1 rounded-full w-fit stat-badge-conversion">
                        @if($deltaConversion !== null)
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        @endif
                        <span>{{ $badgeConversion['label'] }}</span>
                    </div>
                @else
                    <p class="text-3xl font-bold text-slate-900">Locked</p>
                    <div class="mt-2 inline-flex items-center text-xs font-semibold text-slate-600 bg-slate-100 px-2 py-1 rounded-full">Upgrade to view</div>
                @endif
            </div>
            @if(!$isPro)
                <div class="absolute inset-0 bg-white/70 backdrop-blur-sm"></div>
            @endif
        </div>

        {{-- Engagement --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 relative overflow-hidden {{ $isPro ? '' : 'opacity-60' }}">
            <div class="absolute top-4 right-4 w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
            </div>
            <div class="pr-16">
                <p class="text-sm font-medium text-slate-500 mb-1">Engagement Rate</p>
                @if($isPro)
                    <p class="text-3xl font-bold text-slate-900" data-metric="engagement_rate">{{ number_format($analytics['engagement_rate'], 1) }}%</p>
                    <div class="flex items-center mt-2 text-xs font-medium px-2 py-1 rounded-full w-fit stat-badge-engagement">
                        @if($deltaEngagement !== null)
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        @endif
                        <span>{{ $badgeEngagement['label'] }}</span>
                    </div>
                @else
                    <p class="text-3xl font-bold text-slate-900">Locked</p>
                    <div class="mt-2 inline-flex items-center text-xs font-semibold text-slate-600 bg-slate-100 px-2 py-1 rounded-full">Upgrade to view</div>
                @endif
            </div>
            @if(!$isPro)
                <div class="absolute inset-0 bg-white/70 backdrop-blur-sm"></div>
            @endif
        </div>

        {{-- Engagement --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 relative overflow-hidden">
            <div class="absolute top-4 right-4 w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
            </div>
            <div class="pr-16">
                <p class="text-sm font-medium text-slate-500 mb-1">Engagement Rate</p>
                <p class="text-3xl font-bold text-slate-900" data-metric="engagement_rate">{{ number_format($analytics['engagement_rate'], 1) }}%</p>
                <div class="flex items-center mt-2 text-xs font-medium px-2 py-1 rounded-full w-fit stat-badge-engagement">
                    @if($deltaEngagement !== null)
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $badgeEngagement['icon'] }}"></path></svg>
                    @endif
                    <span>{{ $badgeEngagement['label'] }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart Section --}}
    <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-200 mb-8 relative overflow-hidden">
        <div class="flex flex-col sm:flex-row items-center justify-between mb-6 gap-4">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Performance Trends</h2>
                <p class="text-sm text-slate-500">Clicks, saves, dan scan matches 30 hari terakhir</p>
            </div>
            <span class="text-xs font-medium text-slate-500">
                Last update: <span id="lastUpdate">{{ now()->format('H:i:s') }}</span>
            </span>
        </div>

        <div class="relative" style="min-height:300px;">
            <canvas id="performanceChart" style="width:100%;height:280px;"></canvas>
            <div id="chartEmptyState" class="absolute inset-0 hidden items-center justify-center text-sm text-slate-500">Belum ada data untuk ditampilkan.</div>
            @if(!$isPro)
                <div id="chartLockOverlay" class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm flex items-center justify-center text-center text-white">
                    <div class="space-y-3">
                        <p class="text-sm font-semibold">Performance trends terkunci</p>
                        <a href="{{ route('brand.pricing') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-slate-900 rounded-lg font-bold text-sm shadow hover:bg-slate-100">
                            Upgrade untuk membuka
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Top Products Table --}}
    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden relative">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center">
            <h2 class="text-xl font-bold text-slate-900">Top Performing Products</h2>
            <a href="{{ route('brand.products.index') }}" class="text-sm font-bold text-blue-600 hover:text-blue-700">View All</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50/50">
                    <tr>
                        <th class="text-left py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-wider">Product Name</th>
                        <th class="text-left py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-wider">Views</th>
                        <th class="text-left py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-wider">Share of Traffic</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100" id="topProductsTable">
                    @forelse($analytics['top_performing_products'] as $product)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-4">
                                    <img src="{{ $product['image_url'] }}" alt="{{ $product['name'] }}" class="w-10 h-10 rounded-lg object-cover bg-slate-100">
                                    <div>
                                        <p class="font-bold text-slate-900 text-sm">{{ $product['name'] }}</p>
                                        <p class="text-xs text-slate-500">{{ $product['category'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="font-bold text-slate-900">{{ number_format($product['clicks_count']) }}</span>
                                <span class="text-xs text-slate-500 ml-1">clicks</span>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="flex-grow bg-slate-100 rounded-full h-2 w-24">
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $analytics['total_views'] > 0 ? min(100, ($product['clicks_count'] / $analytics['total_views']) * 100) : 0 }}%"></div>
                                    </div>
                                    <span class="text-xs font-medium text-slate-600">{{ $analytics['total_views'] > 0 ? round(($product['clicks_count'] / $analytics['total_views']) * 100, 1) : 0 }}%</span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-12 text-center text-slate-500">
                                No performance data available yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(!$isPro)
            <div id="tableLockOverlay" class="absolute inset-0 bg-slate-900/45 backdrop-blur-sm flex items-center justify-center text-center text-white">
                <div class="space-y-3">
                    <p class="text-sm font-semibold">Top products terkunci di paket Basic</p>
                    <a href="{{ route('brand.pricing') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-slate-900 rounded-lg font-bold text-sm shadow hover:bg-slate-100">
                        Upgrade untuk melihat data
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </a>
                </div>
            </div>
        @endif
    </div>
</x-brand-layout>

@push('scripts')
<script>
    const AnalyticsDashboard = {
        chart: null,
        refreshInterval: 30000, // 30 seconds
        autoRefreshTimer: null,
        isLoading: false,
        isPro: Boolean(@json($isPro)),

        init() {
            console.info('Analytics Dashboard: Initializing...');
            this.setupEventListeners();
            this.renderInitialChart();
            if (!this.isPro) {
                this.showLockedChart();
            }
            this.startAutoRefresh();
        },

        setupEventListeners() {
            const refreshBtn = document.getElementById('refreshBtn');
            if (refreshBtn) {
                refreshBtn.addEventListener('click', () => this.manualRefresh());
            }
        },

        async manualRefresh() {
            if (this.isLoading) return;
            console.info('Manual refresh triggered');
            const btn = document.getElementById('refreshBtn');
            const icon = document.getElementById('refreshIcon');
            
            btn.disabled = true;
            icon.classList.add('animate-spin');
            
            await this.fetchAndUpdateData();
            
            icon.classList.remove('animate-spin');
            btn.disabled = false;
        },

        startAutoRefresh() {
            console.info('Auto-refresh started: every 30 seconds');
            this.autoRefreshTimer = setInterval(() => {
                console.info('Auto-refresh: Fetching latest data...');
                this.fetchAndUpdateData();
            }, this.refreshInterval);
        },

        async fetchAndUpdateData() {
            if (this.isLoading) return;
            this.isLoading = true;

            try {
                const response = await fetch('{{ route("brand.analytics.data") }}', {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                console.info('Analytics data fetched:', data);

                if (typeof data.is_pro !== 'undefined') {
                    this.isPro = Boolean(data.is_pro);
                }

                this.updateMetrics(data.metrics || {}, data.deltas || {});

                if (!this.isPro) {
                    this.showLockedChart();
                    this.updateTimestamp(data.timestamp || new Date().toISOString());
                    return;
                }

                this.hideLockedChart();
                this.updateChart(data.chart);
                this.updateTopProducts(data.top_products || [], data.metrics.total_views || 0);
                this.updateTimestamp(data.timestamp);

            } catch (error) {
                console.error('Error fetching analytics:', error);
            } finally {
                this.isLoading = false;
            }
        },

        updateMetrics(metrics, deltas) {
            if (!metrics) return;

            const metricsMap = {};
            if (typeof metrics.total_views !== 'undefined') metricsMap.total_views = metrics.total_views;
            if (typeof metrics.active_products !== 'undefined') metricsMap.active_products = metrics.active_products;
            if (typeof metrics.conversion_rate !== 'undefined') metricsMap.conversion_rate = Number(metrics.conversion_rate).toFixed(1);
            if (typeof metrics.engagement_rate !== 'undefined') metricsMap.engagement_rate = Number(metrics.engagement_rate).toFixed(1);
            if (deltas && typeof deltas.new_products !== 'undefined') metricsMap.new_products = deltas.new_products;

            Object.entries(metricsMap).forEach(([key, value]) => {
                const element = document.querySelector(`[data-metric="${key}"]`);
                if (!element) return;

                const formattedValue = key.includes('rate') 
                    ? `${value}%` 
                    : Number.isInteger(value) ? value : value;

                if (element.textContent !== String(formattedValue)) {
                    element.textContent = Number.isInteger(value) 
                        ? Number(value).toLocaleString() 
                        : formattedValue;
                    element.classList.add('animate-pulse');
                    setTimeout(() => element.classList.remove('animate-pulse'), 600);
                }
            });

            // Update delta badges with animation
            if (deltas && typeof deltas.views !== 'undefined' && deltas.views !== null) {
                this.updateDeltaBadge('views', deltas.views);
            }
            if (deltas && typeof deltas.conversion !== 'undefined' && deltas.conversion !== null) {
                this.updateDeltaBadge('conversion', deltas.conversion);
            }
            if (deltas && typeof deltas.engagement !== 'undefined' && deltas.engagement !== null) {
                this.updateDeltaBadge('engagement', deltas.engagement);
            }
        },

        updateDeltaBadge(type, delta) {
            const badge = document.querySelector(`.stat-badge-${type}`);
            if (!badge) return;

            const isUp = delta >= 0;
            const newClass = isUp ? 'text-green-600 bg-green-50' : 'text-red-600 bg-red-50';
            const icon = isUp ? 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6' : 'M13 17h8m0 0V9m0 8l-8-8-4 4-6-6';
            
            badge.className = `flex items-center mt-2 text-xs font-medium px-2 py-1 rounded-full w-fit stat-badge-${type} ${newClass}`;
            badge.innerHTML = `
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${icon}"></path>
                </svg>
                <span>${(isUp ? '+' : '') + delta}% vs prev 30d</span>
            `;
        },

        updateChart(chartData) {
            if (!this.isPro || !chartData || !chartData.datasets) {
                this.showLockedChart();
                return;
            }

            const canvas = document.getElementById('performanceChart');
            const emptyState = document.getElementById('chartEmptyState');
            
            if (!canvas) {
                console.warn('Canvas element not found');
                return;
            }

            this.hideLockedChart();

            const hasData = chartData.datasets[0].data.some(v => v > 0) ||
                           chartData.datasets[1].data.some(v => v > 0) ||
                           chartData.datasets[2].data.some(v => v > 0);

            if (!hasData) {
                if (emptyState) {
                    emptyState.classList.remove('hidden');
                    emptyState.classList.add('flex');
                }
                if (this.chart) {
                    this.chart.destroy();
                    this.chart = null;
                }
                return;
            }

            if (emptyState) {
                emptyState.classList.add('hidden');
                emptyState.classList.remove('flex');
            }

            const ctx = canvas.getContext('2d');
            
            if (this.chart) {
                // Update existing chart
                this.chart.data.labels = chartData.labels;
                this.chart.data.datasets[0].data = chartData.datasets[0].data;
                this.chart.data.datasets[1].data = chartData.datasets[1].data;
                this.chart.data.datasets[2].data = chartData.datasets[2].data;
                this.chart.update('none');
            } else {
                // Create new chart
                this.chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: chartData.labels,
                        datasets: [
                            {
                                label: 'Views',
                                data: chartData.datasets[0].data,
                                borderColor: '#2563eb',
                                backgroundColor: 'rgba(37, 99, 235, 0.12)',
                                tension: 0.35,
                                borderWidth: 2,
                                fill: true,
                                pointRadius: 3,
                                pointHoverRadius: 5,
                            },
                            {
                                label: 'Saves',
                                data: chartData.datasets[1].data,
                                borderColor: '#f59e0b',
                                backgroundColor: 'rgba(245, 158, 11, 0.10)',
                                tension: 0.35,
                                borderWidth: 2,
                                fill: true,
                                pointRadius: 3,
                                pointHoverRadius: 5,
                            },
                            {
                                label: 'Scan Matches',
                                data: chartData.datasets[2].data,
                                borderColor: '#10b981',
                                backgroundColor: 'rgba(16, 185, 129, 0.10)',
                                tension: 0.35,
                                borderWidth: 2,
                                fill: true,
                                pointRadius: 3,
                                pointHoverRadius: 5,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: { mode: 'index', intersect: false },
                        plugins: {
                            legend: { 
                                position: 'bottom', 
                                labels: { 
                                    usePointStyle: true,
                                    padding: 15,
                                    font: { size: 12 }
                                } 
                            },
                            tooltip: { 
                                mode: 'index', 
                                intersect: false,
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                padding: 12,
                                callbacks: {
                                    label: function(context) {
                                        let label = context.dataset.label || '';
                                        if (label) label += ': ';
                                        label += Number(context.parsed.y).toLocaleString();
                                        return label;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { 
                                    precision: 0,
                                    callback: function(value) {
                                        return Number(value).toLocaleString();
                                    }
                                },
                                grid: { color: 'rgba(0, 0, 0, 0.05)' }
                            },
                            x: {
                                ticks: { maxRotation: 0, autoSkip: true, maxTicksLimit: 10 },
                                grid: { display: false }
                            }
                        }
                    }
                });
            }

            console.info('Chart updated with latest data');
        },

        showLockedChart() {
            const overlay = document.getElementById('chartLockOverlay');
            if (overlay) {
                overlay.classList.remove('hidden');
                overlay.classList.add('flex');
            }
            if (this.chart) {
                this.chart.destroy();
                this.chart = null;
            }
            const emptyState = document.getElementById('chartEmptyState');
            if (emptyState) {
                emptyState.classList.add('hidden');
                emptyState.classList.remove('flex');
            }
        },

        hideLockedChart() {
            const overlay = document.getElementById('chartLockOverlay');
            if (overlay) {
                overlay.classList.add('hidden');
                overlay.classList.remove('flex');
            }
        },

        updateTopProducts(products, totalViews) {
            if (!this.isPro) return;
            const tableBody = document.getElementById('topProductsTable');
            if (!tableBody) return;

            if (products.length === 0) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="3" class="py-12 text-center text-slate-500">
                            No performance data available yet.
                        </td>
                    </tr>
                `;
                return;
            }

            tableBody.innerHTML = products.map(product => {
                const percentage = totalViews > 0 ? (product.clicks_count / totalViews * 100) : 0;
                return `
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-4">
                                <img src="${product.image_url}" alt="${product.name}" class="w-10 h-10 rounded-lg object-cover bg-slate-100">
                                <div>
                                    <p class="font-bold text-slate-900 text-sm">${product.name}</p>
                                    <p class="text-xs text-slate-500">${product.category}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="font-bold text-slate-900">${Number(product.clicks_count).toLocaleString()}</span>
                            <span class="text-xs text-slate-500 ml-1">clicks</span>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <div class="flex-grow bg-slate-100 rounded-full h-2 w-24">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: ${Math.min(100, percentage)}%"></div>
                                </div>
                                <span class="text-xs font-medium text-slate-600">${percentage.toFixed(1)}%</span>
                            </div>
                        </td>
                    </tr>
                `;
            }).join('');

            console.info(`Updated top products table with ${products.length} products`);
        },

        updateTimestamp(timestamp) {
            const element = document.getElementById('lastUpdate');
            if (element && timestamp) {
                const date = new Date(timestamp);
                element.textContent = date.toLocaleTimeString();
            }
        },

        renderInitialChart() {
            if (!this.isPro) {
                this.showLockedChart();
                return;
            }

            const labels = @json($analytics['chart']['labels'] ?? []);
            const clicks = @json($analytics['chart']['clicks'] ?? []);
            const saves = @json($analytics['chart']['saves'] ?? []);
            const scans = @json($analytics['chart']['scans'] ?? []);

            const canvas = document.getElementById('performanceChart');
            const emptyState = document.getElementById('chartEmptyState');

            if (!canvas) {
                console.warn('performanceChart canvas not found');
                return;
            }

            const hasData = [...clicks, ...saves, ...scans].some(v => Number(v) > 0);
            
            if (!hasData) {
                if (emptyState) {
                    emptyState.classList.remove('hidden');
                    emptyState.classList.add('flex');
                }
                console.info('No chart data available yet');
                return;
            }
            
            if (emptyState) {
                emptyState.classList.add('hidden');
                emptyState.classList.remove('flex');
            }

            try {
                const ctx = canvas.getContext('2d');
                
                if (!ctx) {
                    console.error('Could not get 2d context from canvas');
                    return;
                }

                this.chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels,
                        datasets: [
                            {
                                label: 'Views',
                                data: clicks,
                                borderColor: '#2563eb',
                                backgroundColor: 'rgba(37, 99, 235, 0.12)',
                                tension: 0.35,
                                borderWidth: 2,
                                fill: true,
                                pointRadius: 3,
                                pointHoverRadius: 5,
                            },
                            {
                                label: 'Saves',
                                data: saves,
                                borderColor: '#f59e0b',
                                backgroundColor: 'rgba(245, 158, 11, 0.10)',
                                tension: 0.35,
                                borderWidth: 2,
                                fill: true,
                                pointRadius: 3,
                                pointHoverRadius: 5,
                            },
                            {
                                label: 'Scan Matches',
                                data: scans,
                                borderColor: '#10b981',
                                backgroundColor: 'rgba(16, 185, 129, 0.10)',
                                tension: 0.35,
                                borderWidth: 2,
                                fill: true,
                                pointRadius: 3,
                                pointHoverRadius: 5,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: { 
                            mode: 'index', 
                            intersect: false 
                        },
                        plugins: {
                            legend: { 
                                position: 'bottom', 
                                labels: { 
                                    usePointStyle: true,
                                    padding: 15,
                                    font: { size: 12 }
                                } 
                            },
                            tooltip: { 
                                mode: 'index', 
                                intersect: false,
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                padding: 12,
                                titleFont: { size: 14, weight: 'bold' },
                                bodyFont: { size: 13 },
                                callbacks: {
                                    label: function(context) {
                                        let label = context.dataset.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        label += Number(context.parsed.y).toLocaleString();
                                        return label;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { 
                                    precision: 0,
                                    callback: function(value) {
                                        return Number(value).toLocaleString();
                                    }
                                },
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)'
                                }
                            },
                            x: {
                                ticks: { 
                                    maxRotation: 0, 
                                    autoSkip: true, 
                                    maxTicksLimit: 10 
                                },
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
                console.info('Initial chart rendered successfully with', clicks.length, 'data points');
            } catch (err) {
                console.error('Chart initialization error:', err);
            }
        }
    };

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            // Ensure Chart.js is loaded
            if (typeof Chart === 'undefined') {
                console.error('Chart.js is not loaded!');
                return;
            }
            console.info('Chart.js loaded, initializing dashboard...');
            AnalyticsDashboard.init();
        });
    } else {
        // DOM already ready
        if (typeof Chart === 'undefined') {
            console.error('Chart.js is not loaded!');
        } else {
            console.info('Chart.js loaded, initializing dashboard...');
            AnalyticsDashboard.init();
        }
    }

    // Cleanup on page unload
    window.addEventListener('beforeunload', () => {
        if (AnalyticsDashboard.autoRefreshTimer) {
            clearInterval(AnalyticsDashboard.autoRefreshTimer);
        }
        if (AnalyticsDashboard.chart) {
            AnalyticsDashboard.chart.destroy();
        }
    });
</script>
@endpush