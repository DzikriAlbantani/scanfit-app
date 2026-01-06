<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-900 leading-tight">
            {{ __('Profile Settings') }}
        </h2>
    </x-slot>

    <div class="pt-48 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 lg:gap-8">
                
                <!-- Sidebar Navigation -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden sticky top-28">
                        <nav class="space-y-1 p-4">
                            <a href="#profile-info" class="block px-4 py-3 rounded-lg text-sm font-bold text-blue-600 bg-blue-50 transition">
                                Account Information
                            </a>
                            <a href="#password" class="block px-4 py-3 rounded-lg text-sm font-bold text-slate-600 hover:bg-slate-50 transition">
                                Change Password
                            </a>
                            <a href="#danger" class="block px-4 py-3 rounded-lg text-sm font-bold text-red-600 hover:bg-red-50 transition">
                                Delete Account
                            </a>
                        </nav>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="lg:col-span-3 space-y-6">
                    
                    <!-- Profile Information Section -->
                    <div id="profile-info" class="p-6 lg:p-8 bg-white shadow sm:rounded-2xl border border-slate-200">
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    <!-- Password Section -->
                    <div id="password" class="p-6 lg:p-8 bg-white shadow sm:rounded-2xl border border-slate-200">
                        @include('profile.partials.update-password-form')
                    </div>

                    <!-- Danger Zone -->
                    <div id="danger" class="p-6 lg:p-8 bg-white shadow sm:rounded-2xl border border-red-200">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
