<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - ScanFit</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>html,body{font-family: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;}</style>
</head>
<body class="antialiased bg-slate-50">

<div class="min-h-screen flex">
    <!-- Left / Hero (hidden on mobile) -->
    <div class="hidden md:block md:w-1/2 lg:w-2/5 relative">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?q=80&w=2070&auto=format&fit=crop" alt="hero" class="w-full h-full object-cover">
        </div>
        <div class="absolute inset-0 bg-slate-900/60"></div>

        <div class="relative z-10 h-full flex flex-col">
            <div class="p-6">
                <a href="/" class="text-white text-2xl font-extrabold">ScanFit</a>
            </div>

            <div class="flex-1 flex items-center justify-center px-8">
                <blockquote class="text-center text-white max-w-md">
                    <h2 class="text-4xl sm:text-5xl font-extrabold mb-4">Temukan gaya terbaikmu.</h2>
                    <p class="opacity-90 text-lg">Analisis AI untuk pilihan outfit dari brand lokal yang cocok untukmu.</p>
                </blockquote>
            </div>
        </div>
    </div>

    <!-- Right / Form -->
    <div class="w-full md:w-1/2 lg:w-3/5 flex items-center justify-center relative">
        <div class="absolute -top-16 -right-16 w-64 h-64 bg-blue-100 rounded-full blur-3xl opacity-50"></div>
        <div class="w-full max-w-md p-8">
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8">
                <h1 class="text-2xl font-extrabold text-slate-900">Masuk Akun</h1>
                <p class="text-sm text-slate-500 mt-2">Silakan isi detail akun kamu.</p>

                @if (session('status'))
                    <div class="mt-4 text-sm text-green-600">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="mt-6">
                    @csrf

                    <!-- Email -->
                    <label class="block text-sm font-bold text-slate-700">Email</label>
                    <input id="email" name="email" type="email" required autofocus value="{{ old('email') }}" 
                           class="mt-1 block w-full rounded-xl border border-slate-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-slate-900" />
                    @if (isset($errors) && $errors->has('email'))
                        <p class="text-sm text-red-600 mt-1">{{ $errors->first('email') }}</p>
                    @endif

                    <!-- Password -->
                    <label class="block text-sm font-bold text-slate-700 mt-4">Password</label>
                    <input id="password" name="password" type="password" required 
                           class="mt-1 block w-full rounded-xl border border-slate-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-slate-900" />
                    @if (isset($errors) && $errors->has('password'))
                        <p class="text-sm text-red-600 mt-1">{{ $errors->first('password') }}</p>
                    @endif

                    <div class="flex items-center justify-between mt-4">
                        <label class="flex items-center text-sm">
                            <input type="checkbox" name="remember" id="remember" class="h-4 w-4 text-slate-900 focus:ring-slate-900 border-gray-300 rounded" />
                            <span class="ml-2 text-slate-600">Ingat saya</span>
                        </label>

                        <div>
                            @if (Route::has('password.request'))
                                <a class="text-sm text-slate-500 hover:underline" href="{{ route('password.request') }}">Lupa password?</a>
                            @endif
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="w-full bg-gradient-to-r from-slate-900 to-blue-700 text-white py-3 rounded-xl font-bold hover:shadow-lg hover:-translate-y-0.5 transition">Masuk</button>
                    </div>
                </form>

                <p class="text-sm text-slate-500 text-center mt-6">Belum punya akun? <a href="{{ route('register') }}" class="text-slate-900 font-bold hover:underline">Daftar</a></p>
            </div>
        </div>
    </div>
</div>


</body>
</html>

