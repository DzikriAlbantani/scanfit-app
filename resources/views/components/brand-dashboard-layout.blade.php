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

    {{-- MAIN CONTENT --}}
    <main class="flex-grow">
        {{ $slot }}
    </main>

    {{-- Alpine.js --}}
    <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>