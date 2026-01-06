<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar - ScanFit</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>html,body{font-family: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;}</style>
</head>
<body class="antialiased bg-slate-50">

<div class="min-h-screen flex">
    <!-- Left / Visual (hidden on mobile) -->
    <div class="hidden md:block md:w-1/2 lg:w-2/5 relative">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1558769132-cb1aea458c5e?q=80&w=1974&auto=format&fit=crop" alt="register-hero" class="w-full h-full object-cover">
        </div>
        <div class="absolute inset-0 bg-slate-900/60"></div>

        <div class="relative z-10 h-full flex flex-col">
            <div class="p-6">
                <a href="/" class="text-white text-2xl font-extrabold">ScanFit</a>
            </div>
            <div class="flex-1 flex items-center justify-center px-8">
                <div class="text-center text-white max-w-md">
                    <h2 class="text-4xl sm:text-5xl font-extrabold mb-4">Buat akun kamu.</h2>
                    <p class="opacity-90 text-lg">Gabung dan nikmati rekomendasi outfit dari AI.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Right / Form -->
    <div class="w-full md:w-1/2 lg:w-3/5 flex items-center justify-center relative">
        <div class="absolute -top-16 -right-16 w-64 h-64 bg-purple-100 rounded-full blur-3xl opacity-50"></div>
        <div class="w-full max-w-md p-8">
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8">
                <h1 class="text-3xl font-extrabold text-slate-900">Daftar</h1>
                <p class="text-sm text-slate-500 mt-2">Masukkan detail untuk mulai menggunakan ScanFit.</p>

                <form method="POST" action="{{ route('register') }}" class="mt-6">
                    @csrf

                    <!-- Name -->
                          <label class="block text-sm font-bold text-slate-700">Nama</label>
                    <input id="name" name="name" type="text" required autofocus value="{{ old('name') }}"
                              class="mt-1 block w-full rounded-xl border border-slate-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-slate-900" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />

                    <!-- Email -->
                          <label class="block text-sm font-bold text-slate-700 mt-4">Email</label>
                    <input id="email" name="email" type="email" required value="{{ old('email') }}"
                              class="mt-1 block w-full rounded-xl border border-slate-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-slate-900" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />

                    <!-- Password -->
                          <label class="block text-sm font-bold text-slate-700 mt-4">Password</label>
                    <input id="password" name="password" type="password" required
                              class="mt-1 block w-full rounded-xl border border-slate-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-slate-900" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />

                    <!-- Confirm Password -->
                          <label class="block text-sm font-bold text-slate-700 mt-4">Konfirmasi Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                              class="mt-1 block w-full rounded-xl border border-slate-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-slate-900" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />

                    <div class="mt-6">
                        <button type="submit" class="w-full bg-gradient-to-r from-slate-900 to-purple-700 text-white py-3 rounded-xl font-bold hover:shadow-lg hover:-translate-y-0.5 transition">Daftar</button>
                    </div>
                </form>

                <p class="text-sm text-slate-500 text-center mt-6">Sudah punya akun? <a href="{{ route('login') }}" class="text-slate-900 font-bold hover:underline">Masuk</a></p>
            </div>
        </div>
    </div>
</div>

</body>
</html>
