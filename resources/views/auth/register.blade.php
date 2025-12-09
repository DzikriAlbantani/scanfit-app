<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - ScanFit</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>html,body{font-family: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;}</style>
</head>
<body class="antialiased bg-brand-haze">

<div class="min-h-screen flex">
    <!-- Left / Visual (hidden on mobile) -->
    <div class="hidden md:block md:w-1/2 lg:w-2/5 relative">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1558769132-cb1aea458c5e?q=80&w=1974&auto=format&fit=crop" alt="register-hero" class="w-full h-full object-cover">
        </div>
        <div class="absolute inset-0 bg-[#2F4156]/60"></div>

        <div class="relative z-10 h-full flex flex-col">
            <div class="p-6">
                <a href="/" class="text-white text-2xl font-bold">ScanFit</a>
            </div>
            <div class="flex-1 flex items-center justify-center px-8">
                <div class="text-center text-white max-w-md">
                    <h2 class="text-4xl sm:text-5xl font-extrabold mb-4">Create your account.</h2>
                    <p class="opacity-90 text-lg">Join the fashion revolution.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Right / Form -->
    <div class="w-full md:w-1/2 lg:w-3/5 flex items-center justify-center">
        <div class="w-full max-w-md p-8">
            <div class="bg-white rounded-2xl shadow-md p-8">
                <h1 class="text-3xl font-bold text-[#2F4156]">Sign Up</h1>
                <p class="text-sm text-slate-500 mt-2">Enter your details to get started.</p>

                <form method="POST" action="{{ route('register') }}" class="mt-6">
                    @csrf

                    <!-- Name -->
                    <label class="block text-sm font-medium text-slate-700">Name</label>
                    <input id="name" name="name" type="text" required autofocus value="{{ old('name') }}"
                           class="mt-1 block w-full rounded-lg border border-gray-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#567C8D] focus:border-[#567C8D]" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />

                    <!-- Email -->
                    <label class="block text-sm font-medium text-slate-700 mt-4">Email</label>
                    <input id="email" name="email" type="email" required value="{{ old('email') }}"
                           class="mt-1 block w-full rounded-lg border border-gray-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#567C8D] focus:border-[#567C8D]" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />

                    <!-- Password -->
                    <label class="block text-sm font-medium text-slate-700 mt-4">Password</label>
                    <input id="password" name="password" type="password" required
                           class="mt-1 block w-full rounded-lg border border-gray-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#567C8D] focus:border-[#567C8D]" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />

                    <!-- Confirm Password -->
                    <label class="block text-sm font-medium text-slate-700 mt-4">Confirm Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                           class="mt-1 block w-full rounded-lg border border-gray-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#567C8D] focus:border-[#567C8D]" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />

                    <div class="mt-6">
                        <button type="submit" class="w-full bg-[#2F4156] text-white py-3 rounded-lg font-semibold hover:bg-[#1a2332] transition">Register</button>
                    </div>
                </form>

                <p class="text-sm text-gray-500 text-center mt-6">Already have an account? <a href="{{ route('login') }}" class="text-[#567C8D] font-semibold">Log in</a></p>
            </div>
        </div>
    </div>
</div>

</body>
</html>
