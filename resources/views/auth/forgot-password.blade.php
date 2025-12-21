<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password - ScanFit</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>html,body{font-family: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;}</style>
</head>
<body class="antialiased bg-brand-haze">

<div class="min-h-screen flex">
    <!-- Left / Hero (hidden on mobile) -->
    <div class="hidden md:block md:w-1/2 lg:w-2/5 relative">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?q=80&w=2070&auto=format&fit=crop" alt="hero" class="w-full h-full object-cover">
        </div>
        <div class="absolute inset-0 bg-[#2F4156]/60"></div>

        <div class="relative z-10 h-full flex flex-col">
            <div class="p-6">
                <a href="/" class="text-white text-2xl font-bold">ScanFit</a>
            </div>

            <div class="flex-1 flex items-center justify-center px-8">
                <blockquote class="text-center text-white max-w-md">
                    <h2 class="text-4xl sm:text-5xl font-extrabold mb-4">Find your perfect fit.</h2>
                    <p class="opacity-90 text-lg">Discover styles tailored to you — powered by AI and curated from local brands.</p>
                </blockquote>
            </div>
        </div>
    </div>

    <!-- Right / Form -->
    <div class="w-full md:w-1/2 lg:w-3/5 flex items-center justify-center">
        <div class="w-full max-w-md p-8">
            <div class="bg-white rounded-2xl shadow-md p-8">
                <h1 class="text-2xl font-bold text-brand-dark">Forgot Password</h1>
                <p class="text-sm text-slate-500 mt-2">Enter your email address and we'll send you a link to reset your password.</p>

                @if (session('status'))
                    <div class="mt-4 text-sm text-green-600 bg-green-50 p-3 rounded-lg">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="mt-6">
                    @csrf

                    <!-- Email -->
                    <label class="block text-sm font-medium text-slate-700">Email</label>
                    <input id="email" name="email" type="email" required autofocus value="{{ old('email') }}"
                           class="mt-1 block w-full rounded-lg border border-gray-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#567C8D] focus:border-[#567C8D]" />
                    @if (isset($errors) && $errors->has('email'))
                        <p class="text-sm text-red-600 mt-1">{{ $errors->first('email') }}</p>
                    @endif

                    <div class="mt-6">
                        <button type="submit" class="w-full bg-[#2F4156] text-white py-3 rounded-lg font-semibold hover:bg-[#1a2332] transition">Kirim Link Reset</button>
                    </div>
                </form>

                <p class="text-sm text-slate-500 text-center mt-6">
                    <a href="{{ route('login') }}" class="text-brand-dark font-semibold hover:underline">Kembali ke Login</a>
                </p>
            </div>
        </div>
    </div>
</div>

</body>
</html>
