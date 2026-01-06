<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Google Font: Poppins --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <title>{{ $title ?? 'Brand Dashboard' }} - {{ config('app.name', 'ScanFit') }}</title>

    {{-- Vite / Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Chart.js for Analytics --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <style>
        html, body { font-family: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; }
    </style>

    @stack('head-scripts')
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-50">
    <div class="min-h-screen flex">
        {{-- Sidebar --}}
        <div class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0 z-50">
            <div class="flex flex-col flex-grow bg-slate-900 border-r border-slate-700 pt-5 pb-4 overflow-y-auto">
                <div class="flex items-center flex-shrink-0 px-4">
                    <a href="/" class="flex items-center space-x-2">
                        <img src="{{ asset('images/logo.jpg') }}" alt="ScanFit" class="h-8 w-auto rounded" />
                        <span class="text-xl font-bold text-white">ScanFit</span>
                    </a>
                </div>

                <div class="mt-8 flex-grow flex flex-col">
                    <nav class="flex-1 px-2 space-y-1">
                        {{-- Dashboard --}}
                        <a href="{{ route('brand.dashboard') }}"
                           class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('brand.dashboard') ? 'bg-slate-800 text-white' : 'text-slate-300 hover:text-white hover:bg-slate-800' }}">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('brand.dashboard') ? 'text-blue-400' : 'text-slate-400 group-hover:text-slate-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"></path>
                            </svg>
                            Dashboard
                        </a>

                        {{-- Products --}}
                        <a href="{{ route('brand.products.index') }}"
                           class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('brand.products.*') ? 'bg-slate-800 text-white' : 'text-slate-300 hover:text-white hover:bg-slate-800' }}">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('brand.products.*') ? 'text-blue-400' : 'text-slate-400 group-hover:text-slate-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            My Products
                        </a>

                        {{-- Analytics --}}
                        <a href="{{ route('brand.analytics') }}"
                           class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('brand.analytics') ? 'bg-slate-800 text-white' : 'text-slate-300 hover:text-white hover:bg-slate-800' }}">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('brand.analytics') ? 'text-blue-400' : 'text-slate-400 group-hover:text-slate-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Analytics
                        </a>

                        {{-- Profile --}}
                        <a href="{{ route('brand.profile.edit') }}"
                           class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('brand.profile.*') ? 'bg-slate-800 text-white' : 'text-slate-300 hover:text-white hover:bg-slate-800' }}">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('brand.profile.*') ? 'text-blue-400' : 'text-slate-400 group-hover:text-slate-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Settings
                        </a>
                    </nav>
                </div>

                {{-- User Menu --}}
                <div class="flex-shrink-0 flex border-t border-slate-800 p-4">
                    <div class="flex items-center w-full">
                        <div class="flex-shrink-0">
                            @if(Auth::user()->brand && Auth::user()->brand->logo_url)
                                <img src="{{ Auth::user()->brand->logo_url }}" alt="{{ Auth::user()->brand->brand_name }}" class="h-8 w-8 rounded-full object-cover ring-2 ring-slate-700">
                            @else
                                <div class="h-8 w-8 rounded-full bg-slate-700 flex items-center justify-center ring-2 ring-slate-600">
                                    <span class="text-sm font-medium text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="ml-3 flex-1 min-w-0">
                            <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-slate-400 truncate">{{ Auth::user()->brand->brand_name ?? 'Brand Owner' }}</p>
                        </div>
                        <div class="ml-3 flex-shrink-0">
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-gray-400 hover:text-gray-600">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Mobile menu button --}}
        <div class="md:hidden fixed top-4 left-4 z-50">
            <button @click="sidebarOpen = !sidebarOpen" class="bg-white p-2 rounded-md shadow-lg">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>

        {{-- Mobile sidebar --}}
        <div x-show="sidebarOpen" @click.away="sidebarOpen = false" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-40 md:hidden">
            <div class="fixed inset-0 bg-gray-600 bg-opacity-75" @click="sidebarOpen = false"></div>
            <div class="relative flex-1 flex flex-col max-w-xs w-full bg-white">
                <div class="absolute top-0 right-0 -mr-12 pt-2">
                    <button @click="sidebarOpen = false" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                        <span class="sr-only">Close sidebar</span>
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
                    <div class="flex-shrink-0 flex items-center px-4">
                        <img src="{{ asset('images/logo.jpg') }}" alt="ScanFit" class="h-8 w-auto rounded" />
                        <span class="ml-2 text-xl font-bold text-brand-dark">ScanFit</span>
                    </div>

                    <nav class="mt-5 px-2 space-y-1">
                        <a href="{{ route('brand.dashboard') }}" class="group flex items-center px-2 py-2 text-base font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                            <svg class="mr-4 h-6 w-6 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"></path>
                            </svg>
                            Dashboard
                        </a>

                        <a href="{{ route('brand.products.index') }}" class="group flex items-center px-2 py-2 text-base font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                            <svg class="mr-4 h-6 w-6 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            Products
                        </a>

                        <a href="{{ route('brand.profile.edit') }}" class="group flex items-center px-2 py-2 text-base font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                            <svg class="mr-4 h-6 w-6 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Settings
                        </a>
                    </nav>
                </div>

                <div class="flex-shrink-0 flex border-t border-slate-700 p-4">
                    <div class="flex items-center w-full">
                        <div class="flex-shrink-0">
                            <div class="h-8 w-8 rounded-full bg-slate-600 flex items-center justify-center">
                                <span class="text-sm font-medium text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                        </div>
                        <div class="ml-3 flex-1 min-w-0">
                            <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-slate-400 truncate">{{ Auth::user()->brand->brand_name ?? 'Brand Owner' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main content --}}
        <div class="md:pl-64 flex flex-col flex-1 bg-slate-50">
            <main class="flex-1">
                <div class="py-6">
                    <div class="max-w-7xl mx-auto px-3 sm:px-4 md:px-6 lg:px-8">
                        {{ $slot }}
                    </div>
                </div>
            </main>
        </div>
    </div>

    {{-- Confirm Modal Component --}}
    @include('components.confirm-modal')

    {{-- Alpine.js for mobile menu --}}
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('app', () => ({
                sidebarOpen: false,
            }))
        })
    </script>

    {{-- Product Click Tracking --}}
    <script src="{{ asset('js/click-tracker.js') }}"></script>

    {{-- Confirm Modal Helpers --}}
    <script>
        // Define functions immediately (not in DOMContentLoaded) so onclick handlers can access them
        window.showDeleteItemConfirm = function(itemName, form) {
            window.showDeleteConfirm(itemName, null, form);
        };

        window.showDeleteProductConfirm = function(productName, productId) {
            console.log('showDeleteProductConfirm called:', productName, productId);
            window.openConfirmModal({
                title: 'Delete Product',
                message: `Are you sure you want to delete the product "${productName}"? All associated data will be removed.`,
                type: 'delete',
                showWarning: true,
                onConfirm: () => {
                    console.log('Confirm clicked for product:', productId);
                    const form = document.getElementById(`deleteProductForm${productId}`);
                    console.log('Form element:', form);
                    if (form) {
                        console.log('Submitting form...');
                        form.submit();
                    } else {
                        console.error('Form not found: deleteProductForm' + productId);
                    }
                }
            });
        };

        window.showDeleteBannerConfirm = function(bannerTitle, bannerId) {
            window.openConfirmModal({
                title: 'Delete Banner',
                message: `Are you sure you want to delete the banner "${bannerTitle}"?`,
                type: 'delete',
                showWarning: true,
                onConfirm: () => {
                    const form = document.getElementById(`deleteBannerForm${bannerId}`);
                    if (form) form.submit();
                }
            });
        };

        window.showDeleteAlbumConfirm = function(albumName, form) {
            window.showDeleteConfirm(`Album: ${albumName}`, null, form);
        };

        window.showMoveToClosetConfirm = function(itemName, form) {
            window.openConfirmModal({
                title: 'Move to Closet',
                message: `Move "${itemName}" to main closet?`,
                type: 'warning',
                showWarning: false,
                onConfirm: () => {
                    if (form) form.submit();
                }
            });
        };

        window.showDeleteUserConfirm = function(userName, form) {
            window.openConfirmModal({
                title: 'Delete User',
                message: `Are you sure you want to delete user "${userName}"? This action cannot be undone.`,
                type: 'delete',
                showWarning: true,
                onConfirm: () => {
                    if (form) form.submit();
                }
            });
        };

        window.showDeleteBrandConfirm = function(brandName, form) {
            window.openConfirmModal({
                title: 'Delete Brand',
                message: `Are you sure you want to delete the brand "${brandName}"? All associated data will be permanently deleted.`,
                type: 'delete',
                showWarning: true,
                onConfirm: () => {
                    if (form) form.submit();
                }
            });
        };
    </script>

    {{-- Page specific scripts --}}
    @stack('scripts')
</body>
</html>