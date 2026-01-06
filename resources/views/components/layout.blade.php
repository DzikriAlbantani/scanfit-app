<!doctype html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Google Font: Poppins --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <title>{{ $title ?? config('app.name', 'ScanFit') }}</title>

    {{-- Vite / Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html, body { font-family: 'Poppins', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans antialiased text-slate-800 bg-gray-50 flex flex-col min-h-screen">

    {{-- NAVBAR --}}
    <header x-data="{ open: false, scrolled: false }" 
            @scroll.window="scrolled = (window.pageYOffset > 20)"
            :class="scrolled ? 'bg-white/90 backdrop-blur-md shadow-sm' : 'bg-white/70 backdrop-blur-sm'"
            class="fixed top-0 w-full z-50 transition-all duration-300">
        <nav class="border-b border-transparent transition-colors duration-300" :class="scrolled ? 'border-gray-100' : ''">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-20">
                    
                    {{-- Left: Logo & Text --}}
                    <div class="flex-shrink-0 flex items-center">
                        <a href="/" class="flex items-center gap-3 group">
                            <img src="{{ asset('images/logo.jpg') }}" alt="ScanFit Logo" class="h-10 w-auto rounded-lg shadow-sm transition-transform group-hover:scale-105" />
                            <span class="text-2xl font-black tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-blue-700 via-blue-600 to-purple-600">
                                ScanFit
                            </span>
                        </a>
                    </div>

                    {{-- Center: Links (FIXED SPACING) --}}
                    <div class="hidden md:flex items-center gap-8"> 
                        @foreach(['Home' => '/', 'Scan' => '/scan', 'Explore' => '/explore', 'Closet' => '/closet'] as $label => $url)
                            <a href="{{ $url }}" class="text-[15px] font-semibold text-slate-600 hover:text-slate-900 relative group transition-colors">
                                {{ $label }}
                                <span class="absolute -bottom-1 left-0 w-0 h-[2px] bg-gradient-to-r from-blue-600 to-purple-600 transition-all duration-300 group-hover:w-full"></span>
                            </a>
                        @endforeach
                    </div>

                    {{-- Right: Actions --}}
                    <div class="flex items-center gap-4">
                        <div class="hidden md:flex md:items-center md:gap-3">
                            @auth
                                <div class="relative" x-data="{ dropdownOpen: false }">
                                    <button @click="dropdownOpen = !dropdownOpen" class="flex items-center gap-2 text-sm font-bold text-slate-700 hover:text-slate-900 focus:outline-none bg-white py-2 px-3 rounded-full border border-gray-200 hover:border-gray-300 transition">
                                        <img src="{{ Auth::user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=0F172A&color=fff' }}" alt="{{ Auth::user()->name }}" class="w-7 h-7 rounded-full object-cover">
                                        <span class="truncate max-w-[100px]">{{ Auth::user()->name }}</span>
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>

                                    <div x-show="dropdownOpen" @click.away="dropdownOpen = false" x-transition.origin.top.right class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl py-2 border border-gray-100 ring-1 ring-black ring-opacity-5 focus:outline-none z-50" style="display: none;">
                                        <div class="px-4 py-2 border-b border-gray-100 mb-1">
                                            <p class="text-xs text-gray-500">Signed in as</p>
                                            <p class="text-sm font-bold text-slate-900 truncate">{{ Auth::user()->email }}</p>
                                        </div>
                                        <a href="/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 font-medium transition">Profile Settings</a>
                                        <div class="border-t border-gray-100 mt-1 pt-1">
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-medium transition">Log Out</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <a href="/login" class="text-sm font-bold text-slate-600 hover:text-slate-900 transition px-4 py-2">Log In</a>
                                <a href="/register" class="inline-flex items-center px-6 py-2.5 bg-slate-900 text-white text-sm font-bold rounded-full hover:bg-blue-600 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                                    Sign Up Free
                                </a>
                            @endauth
                        </div>

                        {{-- Mobile Toggle --}}
                        <div class="md:hidden flex items-center">
                            <button @click="open = !open" type="button" class="p-2 rounded-lg text-slate-600 hover:bg-gray-100 transition focus:outline-none">
                                <svg x-show="!open" class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                                <svg x-show="open" class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Mobile Menu --}}
            <div x-show="open" x-collapse class="md:hidden bg-white border-t border-gray-100 shadow-xl max-h-screen overflow-y-auto">
                <div class="px-4 pt-4 pb-6 space-y-2">
                    @foreach(['Home' => '/', 'Scan' => '/scan', 'Explore' => '/explore', 'Closet' => '/closet'] as $label => $url)
                        <a href="{{ $url }}" class="block px-4 py-3 rounded-xl text-base font-semibold text-slate-600 hover:bg-blue-50 hover:text-blue-700 transition">
                            {{ $label }}
                        </a>
                    @endforeach
                    <div class="border-t border-gray-100 my-4 pt-4 space-y-3">
                        @auth
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-3 text-base font-semibold text-red-600 hover:bg-red-50 rounded-xl">Log Out</button>
                            </form>
                        @else
                            <a href="/login" class="block w-full text-center px-4 py-3 rounded-full border-2 border-slate-200 text-base font-bold text-slate-700 hover:border-slate-900 hover:text-slate-900 transition">Log In</a>
                            <a href="/register" class="block w-full text-center px-4 py-3 bg-slate-900 text-white rounded-full text-base font-bold hover:bg-blue-600 transition shadow-md">Sign Up Free</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
    </header>

    {{-- MAIN CONTENT --}}
    <main class="flex-grow">
        {{ $slot }}
    </main>

    {{-- FOOTER (FIXED SPACING) --}}
    <footer class="bg-slate-900 text-slate-300 border-t border-slate-800/50 font-medium">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
                
                {{-- Brand Column --}}
                <div class="space-y-6 col-span-1 md:col-span-2 lg:col-span-1">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.jpg') }}" alt="ScanFit Logo" class="h-10 w-auto rounded-lg grayscale brightness-200" />
                        <span class="text-2xl font-black tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-blue-500 to-purple-500">
                            ScanFit
                        </span>
                    </div>
                    <p class="text-sm leading-6 text-slate-400 pr-4">
                        Platform asisten fashion AI #1 di Indonesia. Temukan outfit impianmu dari brand lokal terbaik.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center hover:bg-blue-600 hover:text-white transition">
                            <span class="sr-only">IG</span>
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                    </div>
                </div>

                {{-- Links Columns (Spacing diperbaiki) --}}
                <div>
                    <h3 class="text-white font-bold text-base mb-4">Produk</h3>
                    <ul class="space-y-3 text-sm">
                        <li><a href="/scan" class="hover:text-blue-400 transition-colors">AI Outfit Scanner</a></li>
                        <li><a href="/closet" class="hover:text-blue-400 transition-colors">Virtual Closet</a></li>
                        <li><a href="/explore" class="hover:text-blue-400 transition-colors">Brand Partner</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-white font-bold text-base mb-4">Perusahaan</h3>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#" class="hover:text-blue-400 transition-colors">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition-colors">Blog</a></li>
                        <li><a href="/brand/register" class="hover:text-blue-400 transition-colors text-blue-400">Join Partner</a></li>
                    </ul>
                </div>

                {{-- Newsletter --}}
                <div>
                    <h3 class="text-white font-bold text-base mb-4">Newsletter</h3>
                    <form class="space-y-3">
                        <input type="email" placeholder="Email kamu" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-3 rounded-lg text-sm transition">
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>

            <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-slate-500">
                <p>© 2025 ScanFit Inc. Indonesia.</p>
                <div class="flex space-x-6">
                    <a href="#" class="hover:text-white transition">Privacy</a>
                    <a href="#" class="hover:text-white transition">Terms</a>
                </div>
            </div>
        </div>
    </footer>

    {{-- Confirm Modal Component --}}
    @include('components.confirm-modal')

    {{-- Confirm Modal Helpers --}}
    <script>
        // Expose helpers globally so inline onclick calls work
        window.showDeleteItemConfirm = function(itemName, form) {
            window.showDeleteConfirm(itemName, null, form);
        };

        window.showDeleteAlbumConfirm = function(albumName, form) {
            window.showDeleteConfirm(`Album: ${albumName}`, null, form);
        };

        window.showMoveToClosetConfirm = function(itemName, form) {
            window.openConfirmModal({
                title: 'Pindahkan ke Closet',
                message: `Pindahkan "${itemName}" ke closet utama?`,
                type: 'warning',
                showWarning: false,
                onConfirm: () => {
                    if (form) form.submit();
                }
            });
        };

        window.showDeleteUserConfirm = function(userName, form) {
            window.openConfirmModal({
                title: 'Hapus Pengguna',
                message: `Yakin menghapus pengguna "${userName}"? Tindakan ini tidak dapat dibatalkan.`,
                type: 'delete',
                showWarning: true,
                onConfirm: () => {
                    if (form) form.submit();
                }
            });
        };

        window.showDeleteBrandConfirm = function(brandName, form) {
            window.openConfirmModal({
                title: 'Hapus Brand',
                message: `Yakin menghapus brand "${brandName}"? Semua data terkait akan dihapus permanen.`,
                type: 'delete',
                showWarning: true,
                onConfirm: () => {
                    if (form) form.submit();
                }
            });
        };
    </script>

    {{-- Product Click Tracking --}}
    <script src="{{ asset('js/click-tracker.js') }}"></script>
    {{-- Alpine.js for interactive components (required by dashboard carousel) --}}
    <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>