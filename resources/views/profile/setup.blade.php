<x-guest-layout>
    <div x-data="setupWizard()" class="min-h-screen bg-gradient-to-b from-gray-50 to-slate-100 flex items-center justify-center p-4 md:p-8">

        <div class="bg-white w-full max-w-[700px] rounded-[2.5rem] shadow-2xl shadow-slate-200/50 overflow-hidden relative flex flex-col" style="min-height: 750px;">
            
            <div class="px-10 md:px-16 pt-12 pb-6 text-center">
                
                <div class="flex justify-center mb-6">
                    <div class="w-14 h-14 bg-[#2F4156] rounded-2xl flex items-center justify-center shadow-sm">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                </div>

                <h2 class="text-3xl font-bold text-slate-800 mb-3">Setup Personalisasi</h2>
                <p class="text-slate-500 text-lg max-w-2xl mx-auto leading-relaxed">Bantu kami mengenal gaya unikmu untuk rekomendasi outfit yang lebih akurat.</p>

                <div class="mt-10 mb-2 flex justify-between text-sm font-bold text-slate-400 tracking-widest uppercase">
                    <span>Langkah <span x-text="step"></span> / <span x-text="totalSteps"></span></span>
                    <span x-text="Math.round(progressPercentage) + '%'"></span>
                </div>
                <div class="h-4 w-full bg-gray-100 rounded-full overflow-hidden relative">
                    <div class="h-full bg-[#2F4156] transition-all duration-500 ease-in-out rounded-full"
                         :style="'width: ' + progressPercentage + '%'">
                    </div>
                </div>
            </div>
            <div class="flex-1 px-10 md:px-16 py-6 overflow-y-auto">
                
                <div x-show="step === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                    <label class="block text-2xl font-bold text-slate-800 mb-6 text-center">Siapa nama panggilanmu?</label>
                    <input type="text" x-model="form.name"
                           class="w-full border-2 border-gray-200 rounded-2xl p-6 text-xl font-medium text-slate-800 focus:border-[#2F4156] focus:ring-0 transition-all placeholder:text-gray-300 text-center"
                           placeholder="Ketik namamu di sini...">
                </div>

                <div x-show="step === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                    <label class="block text-2xl font-bold text-slate-800 mb-8 text-center">Preferensi Gender Pakaian</label>
                    <div class="grid grid-cols-3 gap-6">
                        <template x-for="option in ['Pria', 'Wanita', 'Unisex']">
                            <button @click="form.gender = option"
                                    :class="{'bg-[#2F4156] text-white border-[#2F4156]': form.gender === option, 
                                             'bg-white text-slate-700 border-gray-200 hover:border-[#2F4156]/50 hover:bg-gray-50': form.gender !== option}"
                                    class="py-8 px-6 rounded-2xl border-2 transition-all duration-200 font-bold text-xl shadow-sm">
                                <span x-text="option"></span>
                            </button>
                        </template>
                    </div>
                </div>

                <div x-show="step === 3" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                    <label class="block text-2xl font-bold text-slate-800 mb-8 text-center">Gaya Pakaian Favorit</label>
                    <div class="grid grid-cols-2 gap-5">
                        <template x-for="style in ['Casual', 'Streetwear', 'Formal', 'Vintage', 'Minimalist', 'Sporty', 'Korean Style', 'Bohemian']">
                            <button @click="form.style_preference = style"
                                    :class="{'bg-[#2F4156] text-white border-[#2F4156]': form.style_preference === style, 
                                             'bg-white text-slate-700 border-gray-200 hover:border-[#2F4156]/50 hover:bg-gray-50': form.style_preference !== style}"
                                    class="py-5 px-8 rounded-2xl border-2 transition-all duration-200 font-bold text-lg text-left h-20 flex items-center shadow-sm">
                                <span x-text="style"></span>
                            </button>
                        </template>
                    </div>
                </div>

                <div x-show="step === 4" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                    <label class="block text-2xl font-bold text-slate-800 mb-8 text-center">Tone Warna Kulit</label>
                    <div class="grid grid-cols-2 gap-6">
                        <template x-for="tone in ['Fair', 'Medium', 'Olive', 'Dark']">
                            <button @click="form.skin_tone = tone"
                                    :class="{'bg-[#2F4156] text-white border-[#2F4156]': form.skin_tone === tone, 
                                             'bg-white text-slate-700 border-gray-200 hover:border-[#2F4156]/50 hover:bg-gray-50': form.skin_tone !== tone}"
                                    class="py-6 px-8 rounded-2xl border-2 transition-all duration-200 font-bold text-xl text-left h-24 flex items-center justify-between group shadow-sm">
                                <span x-text="tone"></span>
                                <div class="w-10 h-10 rounded-full border-2 border-white/30 shadow-inner"
                                     :class="{
                                        'bg-[#F3E2D3]': tone === 'Fair',
                                        'bg-[#E3C4A8]': tone === 'Medium',
                                        'bg-[#C6A992]': tone === 'Olive',
                                        'bg-[#8D6E63]': tone === 'Dark'
                                     }"></div>
                            </button>
                        </template>
                    </div>
                </div>

                <div x-show="step === 5" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                    <label class="block text-2xl font-bold text-slate-800 mb-8 text-center">Ukuran Tubuh Umum</label>
                    <div class="grid grid-cols-3 gap-6">
                        <template x-for="size in ['Slim', 'Medium', 'Plus']">
                            <button @click="form.body_size = size"
                                    :class="{'bg-[#2F4156] text-white border-[#2F4156]': form.body_size === size, 
                                             'bg-white text-slate-700 border-gray-200 hover:border-[#2F4156]/50 hover:bg-gray-50': form.body_size !== size}"
                                    class="py-8 px-6 rounded-2xl border-2 transition-all duration-200 font-bold text-xl shadow-sm">
                                <span x-text="size"></span>
                            </button>
                        </template>
                    </div>
                </div>

                 <div x-show="step === 6" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                    <label class="block text-2xl font-bold text-slate-800 mb-8 text-center">Warna Dominan di Lemari</label>
                    <div class="grid grid-cols-3 gap-5">
                        <template x-for="color in ['Hitam', 'Putih', 'Abu-abu', 'Biru', 'Merah', 'Hijau', 'Kuning', 'Pink', 'Coklat']">
                            <button @click="form.favorite_color = color"
                                    :class="{'bg-[#2F4156] text-white border-[#2F4156]': form.favorite_color === color, 
                                             'bg-white text-slate-700 border-gray-200 hover:border-[#2F4156]/50 hover:bg-gray-50': form.favorite_color !== color}"
                                    class="py-5 px-6 rounded-2xl border-2 transition-all duration-200 font-bold text-lg shadow-sm">
                                <span x-text="color"></span>
                            </button>
                        </template>
                    </div>
                </div>

                 <div x-show="step === 7" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                    <label class="block text-2xl font-bold text-slate-800 mb-8 text-center">Kebutuhan Utama Berpakaian</label>
                    <div class="grid grid-cols-2 gap-5">
                        <template x-for="need in ['Sehari-hari', 'Kerja / Kantor', 'Kampus', 'Konten Creator', 'Hangout', 'Formal Event']">
                            <button @click="form.main_need = need"
                                    :class="{'bg-[#2F4156] text-white border-[#2F4156]': form.main_need === need, 
                                             'bg-white text-slate-700 border-gray-200 hover:border-[#2F4156]/50 hover:bg-gray-50': form.main_need !== need}"
                                    class="py-5 px-8 rounded-2xl border-2 transition-all duration-200 font-bold text-lg text-left h-20 flex items-center shadow-sm">
                                <span x-text="need"></span>
                            </button>
                        </template>
                    </div>
                </div>
            </div>
            <div class="px-10 md:px-16 py-10 bg-white mt-auto">
                <div class="grid grid-cols-2 gap-6">
                    
                    <button @click="prevStep"
                            :disabled="step === 1"
                            :class="{'opacity-0 pointer-events-none': step === 1}"
                            class="w-full py-5 rounded-2xl bg-[#F3F0EB] text-[#2F4156] font-extrabold text-lg hover:bg-[#e8e4dc] transition-colors tracking-wide">
                        Kembali
                    </button>

                    <button @click="nextStep"
                            x-show="step < totalSteps"
                            :disabled="!canProceed"
                            :class="{'bg-[#2F4156] hover:opacity-90 text-white shadow-lg shadow-[#2F4156]/30': canProceed, 
                                     'bg-gray-200 text-gray-400 cursor-not-allowed': !canProceed}"
                            class="w-full py-5 rounded-2xl font-extrabold text-lg transition-all tracking-wide">
                        Lanjut
                    </button>

                    <form method="POST" action="{{ route('profile.store') }}" x-show="step === totalSteps" class="w-full">
                        @csrf
                        <input type="hidden" name="name" :value="form.name">
                        <input type="hidden" name="gender" :value="form.gender">
                        <input type="hidden" name="style_preference" :value="form.style_preference">
                        <input type="hidden" name="skin_tone" :value="form.skin_tone">
                        <input type="hidden" name="body_size" :value="form.body_size">
                        <input type="hidden" name="favorite_color" :value="form.favorite_color">
                        <input type="hidden" name="main_need" :value="form.main_need">

                        <button type="submit"
                                :disabled="!canProceed"
                                :class="{'bg-[#2F4156] hover:opacity-90 text-white shadow-lg shadow-[#2F4156]/30': canProceed, 
                                         'bg-gray-200 text-gray-400 cursor-not-allowed': !canProceed}"
                                class="w-full py-5 rounded-2xl font-extrabold text-lg transition-all tracking-wide flex items-center justify-center gap-2">
                            Selesai
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('setupWizard', () => ({
                step: 1,
                totalSteps: 7,
                form: {
                    name: '{{ Auth::user()->name }}',
                    gender: '',
                    style_preference: '',
                    skin_tone: '',
                    body_size: '',
                    favorite_color: '',
                    main_need: ''
                },
                get progressPercentage() {
                    return (this.step / this.totalSteps) * 100;
                },
                get canProceed() {
                    switch(this.step) {
                        case 1: return this.form.name.trim().length > 0;
                        case 2: return this.form.gender !== '';
                        case 3: return this.form.style_preference !== '';
                        case 4: return this.form.skin_tone !== '';
                        case 5: return this.form.body_size !== '';
                        case 6: return this.form.favorite_color !== '';
                        case 7: return this.form.main_need !== '';
                        default: return false;
                    }
                },
                nextStep() {
                    if (this.canProceed && this.step < this.totalSteps) this.step++;
                },
                prevStep() {
                    if (this.step > 1) this.step--;
                }
            }));
        });
    </script>
</x-guest-layout>