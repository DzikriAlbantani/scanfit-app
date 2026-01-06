<x-layout>
    <x-slot:title>{{ $album->name }} - Lemari Pakaianku</x-slot:title>

    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>

    <div x-data="{ 
            renameModal: false,
            editAlbumModal: false,
            addItemModal: false,
            selectedItem: null,
            openRenameModal(itemId, itemName, itemDesc) {
                this.selectedItem = itemId;
                this.renameModal = true;
                this.$nextTick(() => {
                    this.$refs.renameName.value = itemName;
                    this.$refs.renameDescription.value = itemDesc || '';
                    this.$refs.renameForm.action = '/closet/' + itemId; 
                });
            }
         }" 
         class="min-h-screen bg-slate-50">

        <section class="relative overflow-hidden bg-white pb-12 pt-48 border-b border-slate-200">
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-50 rounded-full blur-3xl opacity-60 -mr-20 -mt-20 pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <a href="{{ route('closet.index') }}" class="inline-flex items-center text-sm font-bold text-blue-600 hover:text-blue-700 mb-6 group">
                    <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Kembali ke Lemari Pakaianku
                </a>

                <div class="space-y-4 text-center md:text-left mb-8">
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                        {{ $album->name }}
                    </h1>
                    @if($album->description)
                    <p class="text-base text-slate-600 max-w-2xl mx-auto md:mx-0">{{ $album->description }}</p>
                    @endif
                </div>

                <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                    <div class="flex gap-3 items-center">
                        <span class="text-sm font-medium text-slate-600">{{ $items->total() }} Item · {{ $album->created_at->format('d M Y') }}</span>
                    </div>

                    <div class="flex gap-3 w-full md:w-auto">
                        <button @click="editAlbumModal = true" class="flex items-center gap-2 px-6 py-3 bg-slate-900 text-white rounded-full font-bold text-sm hover:bg-slate-800 transition-all shadow-sm whitespace-nowrap flex-1 md:flex-none justify-center md:justify-start">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit
                        </button>
                        <form id="deleteAlbumForm" action="{{ route('closet.album.destroy', $album) }}" method="POST" class="inline flex-1 md:flex-none">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="showDeleteAlbumConfirm('{{ addslashes($album->name) }}', document.getElementById('deleteAlbumForm'))" class="w-full flex items-center gap-2 px-6 py-3 bg-red-600 text-white rounded-full font-bold text-sm hover:bg-red-700 transition-all shadow-sm whitespace-nowrap justify-center md:justify-start">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

            {{-- ITEM GRID --}}
            @if($items->count() > 0)
            <div>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                    @foreach($items ?? [] as $item)
                        <div class="group bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 flex flex-col overflow-hidden">
                            
                            <div class="relative aspect-[4/5] overflow-hidden bg-slate-100">
                                @if($item->image_url)
                                    <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-300">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                                <span class="absolute top-3 left-3 text-[10px] font-bold px-2.5 py-1 rounded border uppercase tracking-wider bg-white/95 backdrop-blur-sm text-slate-900 border-slate-200 shadow-sm">
                                    {{ $item->category }}
                                </span>
                            </div>

                            <div class="p-4 flex-grow flex flex-col">
                                <h3 class="font-bold text-slate-900 text-sm leading-tight mb-1 line-clamp-1 group-hover:text-blue-600 transition-colors">{{ $item->name }}</h3>
                                <p class="text-xs text-slate-500 line-clamp-2 mb-4 flex-1">{{ $item->description }}</p>
                                
                                <div class="flex gap-2 pt-3 border-t border-slate-200">
                                    <button @click="openRenameModal({{ $item->id }}, '{{ addslashes($item->name) }}', '{{ addslashes($item->description) }}')" 
                                            class="flex-1 flex items-center justify-center py-2 text-slate-400 hover:text-blue-600 transition-colors text-sm" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>
                                    
                                    <form id="moveToClosetForm{{ $item->id }}" action="{{ route('closet.item.remove-from-album', $item) }}" method="POST" class="contents">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="showMoveToClosetConfirm('{{ addslashes($item->name) }}', document.getElementById('moveToClosetForm{{ $item->id }}'))" class="flex-1 flex items-center justify-center py-2 text-slate-400 hover:text-orange-600 transition-colors text-sm" title="Pindahkan">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if(isset($items) && $items->hasPages())
                    <div class="mt-12 pt-6 border-t border-slate-200">
                        {{ $items->links() }}
                    </div>
                @endif
            </div>
            @else
            {{-- Empty State --}}
            <div class="py-20 text-center">
                <div class="max-w-md mx-auto">
                    <div class="w-24 h-24 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Album Masih Kosong</h3>
                    <p class="text-slate-600 mb-8">
                        Album ini belum memiliki item.
                    </p>
                    <a href="{{ route('closet.index') }}" class="inline-flex items-center px-6 py-3 bg-slate-900 text-white rounded-full font-bold hover:bg-slate-800 transition-colors shadow-md">
                        Kembali ke Closet
                    </a>
                </div>
            </div>
            @endif
        </div>

        {{-- EDIT ALBUM MODAL --}}
        <div x-show="editAlbumModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" @keydown.escape="editAlbumModal = false">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="editAlbumModal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm" @click="editAlbumModal = false"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                <div x-show="editAlbumModal" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form method="POST" action="{{ route('closet.album.update', $album) }}">
                        @csrf
                        @method('PATCH')
                        <div class="bg-white px-6 pt-6 pb-6 border-b border-slate-200">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-lg font-bold text-slate-900">Edit Album</h3>
                                <button type="button" @click="editAlbumModal = false" class="text-slate-400 hover:text-slate-600">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-bold text-slate-900 mb-2">Nama Album</label>
                                    <input type="text" name="name" value="{{ $album->name }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-slate-900 focus:ring-0 text-slate-900 transition-all" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-900 mb-2">Deskripsi (Opsional)</label>
                                    <textarea name="description" rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-slate-900 focus:ring-0 text-slate-900 transition-all">{{ $album->description }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="bg-slate-50 px-6 py-4 flex flex-row-reverse gap-3 border-t border-slate-200">
                            <button type="submit" class="inline-flex justify-center rounded-xl px-6 py-2.5 bg-slate-900 text-sm font-bold text-white hover:bg-slate-800 transition-all shadow-md">
                                Simpan Perubahan
                            </button>
                            <button type="button" @click="editAlbumModal = false" class="inline-flex justify-center rounded-xl px-6 py-2.5 bg-white border border-slate-200 text-sm font-bold text-slate-700 hover:bg-slate-50 transition-all">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- EDIT ITEM MODAL --}}
        <div x-show="renameModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" @keydown.escape="renameModal = false">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="renameModal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm" @click="renameModal = false"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                <div x-show="renameModal" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form method="POST" action="#" x-ref="renameForm">
                        @csrf
                        @method('PATCH')
                        <div class="bg-white px-6 pt-6 pb-6 border-b border-slate-200">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-lg font-bold text-slate-900">Edit Detail Item</h3>
                                <button type="button" @click="renameModal = false" class="text-slate-400 hover:text-slate-600">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-bold text-slate-900 mb-2">Nama Item</label>
                                    <input type="text" name="name" x-ref="renameName" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-slate-900 focus:ring-0 text-slate-900 transition-all" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-900 mb-2">Catatan (Opsional)</label>
                                    <textarea name="description" x-ref="renameDescription" rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-slate-900 focus:ring-0 text-slate-900 transition-all" placeholder="Tambahkan catatan tentang item ini..."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="bg-slate-50 px-6 py-4 flex flex-row-reverse gap-3 border-t border-slate-200">
                            <button type="submit" class="inline-flex justify-center rounded-xl px-6 py-2.5 bg-slate-900 text-sm font-bold text-white hover:bg-slate-800 transition-all shadow-md">
                                Simpan Perubahan
                            </button>
                            <button type="button" @click="renameModal = false" class="inline-flex justify-center rounded-xl px-6 py-2.5 bg-white border border-slate-200 text-sm font-bold text-slate-700 hover:bg-slate-50 transition-all">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
                            </button>
                            <button type="button" @click="renameModal = false" class="inline-flex justify-center rounded-xl px-6 py-2.5 bg-white border border-slate-200 text-sm font-bold text-slate-700 hover:bg-slate-50 transition-all">
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout>
