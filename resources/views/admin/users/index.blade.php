<x-layout>
    <x-slot:title>Manajemen Pengguna - Admin</x-slot:title>

    <div class="min-h-screen bg-slate-50">
        <section class="relative overflow-hidden bg-white pb-12 pt-48 border-b border-slate-200">
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-50 rounded-full blur-3xl opacity-60 -mr-20 -mt-20 pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="space-y-4 text-center md:text-left">
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                        Manajemen <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">Pengguna</span>
                    </h1>
                    <p class="text-base text-slate-600 max-w-2xl mx-auto md:mx-0">
                        Kelola data pengguna, status, dan aktivitas mereka.
                    </p>
                </div>

                <div class="mt-8 flex flex-col md:flex-row gap-4 items-center justify-between">
                    <form action="{{ route('admin.users') }}" method="GET" class="relative w-full md:max-w-md group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400 group-focus-within:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." 
                               class="block w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-full text-base text-slate-900 placeholder-slate-400 focus:border-slate-900 focus:ring-0 transition-all shadow-sm hover:border-slate-300">
                    </form>

                    <div class="flex gap-2">
                        <a href="{{ route('admin.users') }}" class="flex items-center gap-2 px-5 py-2.5 rounded-full font-bold text-sm transition-all whitespace-nowrap border shadow-sm {{ !request('filter') ? 'bg-slate-900 text-white border-slate-900' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">
                            Semua
                        </a>
                        <a href="{{ route('admin.users', ['filter' => 'premium']) }}" class="flex items-center gap-2 px-5 py-2.5 rounded-full font-bold text-sm transition-all whitespace-nowrap border shadow-sm {{ request('filter') === 'premium' ? 'bg-slate-900 text-white border-slate-900' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">
                            Premium
                        </a>
                        <a href="{{ route('admin.users', ['filter' => 'free']) }}" class="flex items-center gap-2 px-5 py-2.5 rounded-full font-bold text-sm transition-all whitespace-nowrap border shadow-sm {{ request('filter') === 'free' ? 'bg-slate-900 text-white border-slate-900' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">
                            Free
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[640px]">
                        <thead>
                            <tr class="border-b border-slate-200 bg-slate-50">
                                <th class="px-6 py-4 text-left text-sm font-bold text-slate-900">Nama</th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-slate-900">Email</th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-slate-900">Tipe</th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-slate-900">Terdaftar</th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-slate-900">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @forelse($users as $user)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                            <span class="text-sm font-bold text-blue-600">{{ substr($user->name, 0, 1) }}</span>
                                        </div>
                                        <span class="font-semibold text-slate-900">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">{{ $user->email }}</td>
                                <td class="px-6 py-4">
                                    @if($user->is_premium)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-700">⭐ Premium</span>
                                    @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700">Free</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">{{ $user->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.users.show', $user) }}" class="px-3 py-1.5 text-xs font-bold bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition">
                                            Detail
                                        </a>
                                        <form id="deleteUserForm{{ $user->id }}" action="{{ route('admin.users.delete', $user) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="showDeleteUserConfirm('{{ addslashes($user->name) }}', document.getElementById('deleteUserForm{{ $user->id }}'))" class="px-3 py-1.5 text-xs font-bold bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                    Tidak ada pengguna ditemukan
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($users->hasPages())
                <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
                    {{ $users->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-layout>
