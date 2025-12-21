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

    <title>{{ $title ?? config('app.name', 'ScanFit') }}</title>

    {{-- Vite / Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html, body { font-family: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; }
    </style>

    {{-- Alpine.js for mobile menu (optional) --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased text-brand-dark bg-brand-haze">

    {{-- NAVBAR --}}
    <header x-data="{ open: false }" class="sticky top-0 z-40 bg-brand-bg border-b border-gray-300 py-4">
        <nav>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    {{-- Left: Logo --}}
                    <div class="flex-shrink-0 flex items-center">
                        <a href="/" class="flex items-center space-x-2">
                            <img src="{{ asset('images/logo.jpg') }}" alt="ScanFit" class="h-8 w-auto rounded" />
                        </a>
                    </div>

                    {{-- Center: Links (hidden on small) --}}
                    <div class="hidden md:flex md:space-x-8">
                        <a href="/" class="text-sm font-medium text-brand-dark hover:text-brand-secondary transition">Home</a>
                        <a href="/scan" class="text-sm font-medium text-brand-dark hover:text-brand-secondary transition">Scan</a>
                        <a href="/explore" class="text-sm font-medium text-brand-dark hover:text-brand-secondary transition">Explore</a>
                        <a href="/closet" class="text-sm font-medium text-brand-dark hover:text-brand-secondary transition">Closet</a>
                        <a href="/profile" class="text-sm font-medium text-brand-dark hover:text-brand-secondary transition">Profile</a>
                    </div>

                    {{-- Right: Actions --}}
                    <div class="flex items-center space-x-4">
                        <div class="hidden md:flex md:items-center md:space-x-6">
                            @auth
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-brand-dark text-white text-sm font-medium rounded-full hover:bg-brand-dark/90 transition">
                                        Logout
                                    </button>
                                </form>
                            @else
                                <a href="#" class="text-xs font-bold uppercase text-brand-dark hover:text-brand-secondary transition">COLLABORATE</a>
                                <a href="/login" class="text-xs font-medium text-brand-dark hover:text-brand-secondary transition">LOGIN</a>
                                <a href="/register" aria-label="Sign Up" class="inline-flex items-center px-5 py-2 border-2 border-brand-dark text-brand-dark bg-brand-beige text-xs font-bold rounded-full hover:bg-brand-dark hover:text-white transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 21v-2a4 4 0 00-8 0v2M12 11a4 4 0 100-8 4 4 0 000 8zm8 7v-2a4 4 0 00-3-3.87M4 17v-2a4 4 0 013-3.87" /></svg>
                                    Sign Up
                                </a>
                            @endauth
                        </div>

                        {{-- Mobile menu button --}}
                        <div class="md:hidden">
                            <button @click="open = !open" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-brand-dark hover:bg-gray-200 focus:outline-none">
                                <span x-show="!open">&#9776;</span>
                                <span x-show="open">&times;</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Mobile Menu --}}
            <div x-show="open" x-cloak class="md:hidden bg-brand-bg border-t border-gray-300">
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                    <a href="/" class="block px-3 py-2 rounded text-sm font-medium text-brand-dark hover:bg-gray-200">Home</a>
                    <a href="/scan" class="block px-3 py-2 rounded text-sm font-medium text-brand-dark hover:bg-gray-200">Scan</a>
                    <a href="/explore" class="block px-3 py-2 rounded text-sm font-medium text-brand-dark hover:bg-gray-200">Explore</a>
                    <a href="/closet" class="block px-3 py-2 rounded text-sm font-medium text-brand-dark hover:bg-gray-200">Closet</a>
                    <a href="/profile" class="block px-3 py-2 rounded text-sm font-medium text-brand-dark hover:bg-gray-200">Profile</a>
                    <div class="border-t border-gray-300 mt-2 pt-2">
                        @auth
                            <form method="POST" action="{{ route('logout') }}" class="px-3 py-2">
                                @csrf
                                <button type="submit" class="w-full text-left bg-brand-dark text-white px-3 py-2 rounded font-medium">Logout</button>
                            </form>
                        @else
                            <a href="#" class="block px-3 py-2 text-xs font-bold uppercase text-brand-dark hover:bg-gray-200">COLLABORATE</a>
                            <a href="/login" class="block px-3 py-2 text-xs font-medium text-brand-dark hover:bg-gray-200">LOGIN</a>
                            <a href="/register" aria-label="Sign Up" class="block px-3 py-2 text-xs font-bold border-2 border-brand-dark text-brand-dark bg-brand-beige rounded text-center mt-2 hover:bg-brand-dark hover:text-white transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="inline h-4 w-4 mr-1 align-text-bottom" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 21v-2a4 4 0 00-8 0v2M12 11a4 4 0 100-8 4 4 0 000 8zm8 7v-2a4 4 0 00-3-3.87M4 17v-2a4 4 0 013-3.87" /></svg>
                                Sign Up
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
    </header>

    {{-- MAIN CONTENT --}}
    <main class="min-h-screen pt-0 pb-12">
        {{ $slot }}
    </main>

    {{-- FOOTER --}}
    <footer class="text-white" style="background-color: #1a2332;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                {{-- Column 1: About --}}
                <div>
                    <h5 class="font-bold mb-4">Mulai sekarang dan temukan padanan gayamu</h5>
                    <div class="flex space-x-4 mb-4">
                        <a href="#" class="text-gray-300 hover:text-white transition">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2s9 5 20 5a9.5 9.5 0 00-9-5.5c4.75 2.25 7-7 7-7z"></path></svg>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white transition">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                        </a>
                    </div>
                    <input type="email" placeholder="wafi@mail.com" class="w-full px-3 py-2 rounded text-brand-dark text-sm mb-2">
                    <button class="w-full bg-white text-brand-dark px-3 py-2 rounded text-sm font-semibold hover:opacity-90">Masuk</button>
                </div>

                {{-- Column 2: Fitur --}}
                <div>
                    <h5 class="font-bold mb-4">Fitur</h5>
                    <ul class="space-y-2 text-gray-300">
                        <li><a href="#" class="hover:text-white transition text-sm">AI Outfit Scanner</a></li>
                        <li><a href="#" class="hover:text-white transition text-sm">Mix & Match</a></li>
                        <li><a href="#" class="hover:text-white transition text-sm">Outfit Recommendation</a></li>
                    </ul>
                </div>

                {{-- Column 3: Panduan --}}
                <div>
                    <h5 class="font-bold mb-4">Panduan</h5>
                    <ul class="space-y-2 text-gray-300">
                        <li><a href="#" class="hover:text-white transition text-sm">Tutorial</a></li>
                        <li><a href="#" class="hover:text-white transition text-sm">Tips Gaya</a></li>
                        <li><a href="#" class="hover:text-white transition text-sm">FAQ</a></li>
                    </ul>
                </div>

                {{-- Column 4: Tentang --}}
                <div>
                    <h5 class="font-bold mb-4">Tentang</h5>
                    <ul class="space-y-2 text-gray-300">
                        <li><a href="#" class="hover:text-white transition text-sm">Tentang ScanFit</a></li>
                        <li><a href="#" class="hover:text-white transition text-sm">Kebijakan Privasi</a></li>
                        <li><a href="#" class="hover:text-white transition text-sm">Ketentuan Layanan</a></li>
                    </ul>
                </div>
            </div>

            {{-- Copyright --}}
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400 text-sm">
                <p>&copy; 2025 ScanFit. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>
