<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        {{-- Confirm Modal Component --}}
        @include('components.confirm-modal')

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
    </body>
</html>
