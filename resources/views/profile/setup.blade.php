<x-guest-layout :hide-logo="true" :wide="true">
    <div x-data="setupWizard()" class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-blue-50 flex items-center justify-center p-4 md:p-8">

        <div class="bg-white w-full max-w-5xl rounded-[2rem] shadow-2xl shadow-blue-200/40 overflow-hidden relative flex flex-col" style="min-height: 780px;">
            
            <div class="px-6 md:px-12 lg:px-16 pt-10 pb-6 text-center">
                
                

                <h2 class="text-3xl font-extrabold text-slate-900 mb-2">Setup Personalisasi</h2>
                <p class="text-slate-600 text-base md:text-lg max-w-2xl mx-auto leading-relaxed">Bantu kami mengenal gaya unikmu untuk rekomendasi outfit yang lebih akurat.</p>

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
            <div class="flex-1 px-6 md:px-12 lg:px-16 py-6 overflow-y-auto">
                
                <div x-show="step === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                    <label class="block text-2xl font-bold text-slate-900 mb-6 text-center">Siapa nama panggilanmu?</label>
                    <input type="text" x-model="form.name"
                           class="w-full border border-slate-200 rounded-2xl p-5 text-lg md:text-xl font-medium text-slate-800 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all placeholder:text-slate-400 text-center"
                           placeholder="Ketik namamu di sini...">
                </div>

                <div x-show="step === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                    <label class="block text-2xl font-bold text-slate-900 mb-8 text-center">Preferensi Gender Pakaian</label>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 md:gap-6">
                        <template x-for="option in ['Pria', 'Wanita', 'Unisex']">
                            <button @click="form.gender = option"
                                    :class="{
                                        'bg-gradient-to-br from-blue-600 to-indigo-600 text-white border-transparent ring-2 ring-blue-200': form.gender === option,
                                        'bg-white text-slate-800 border-slate-200 hover:border-blue-300 hover:bg-slate-50': form.gender !== option
                                    }"
                                    class="py-7 md:py-8 px-6 rounded-2xl border transition-all duration-200 font-bold text-lg md:text-xl shadow-sm h-24 flex items-center justify-center">
                                <span x-text="option"></span>
                            </button>
                        </template>
                    </div>
                </div>

                <div x-show="step === 3" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                    <label class="block text-2xl font-bold text-slate-900 mb-8 text-center">Gaya Pakaian Favorit</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 md:gap-5">
                        <template x-for="style in [
                            { label: 'Casual', value: 'casual' },
                            { label: 'Streetwear', value: 'street' },
                            { label: 'Formal', value: 'formal' },
                            { label: 'Vintage', value: 'vintage' },
                            { label: 'Minimalist', value: 'minimal' },
                            { label: 'Sporty', value: 'sport' },
                            { label: 'Korean Style', value: 'street' },
                            { label: 'Bohemian', value: 'vintage' },
                        ]">
                            <button @click="form.style_preference = style.value"
                                    :class="{
                                        'bg-gradient-to-br from-blue-600 to-indigo-600 text-white border-transparent ring-2 ring-blue-200': form.style_preference === style.value,
                                        'bg-white text-slate-800 border-slate-200 hover:border-blue-300 hover:bg-slate-50': form.style_preference !== style.value
                                    }"
                                    class="px-6 rounded-2xl border transition-all duration-200 font-bold text-base md:text-lg h-24 flex items-center justify-center text-center shadow-sm">
                                <span x-text="style.label"></span>
                            </button>
                        </template>
                    </div>
                </div>

                <div x-show="step === 4" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                    <label class="block text-2xl font-bold text-slate-900 mb-8 text-center">Tone Warna Kulit</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
                        <template x-for="tone in ['Fair', 'Medium', 'Olive', 'Dark']">
                            <button @click="form.skin_tone = tone"
                                    :class="{
                                        'bg-gradient-to-br from-blue-600 to-indigo-600 text-white border-transparent ring-2 ring-blue-200': form.skin_tone === tone,
                                        'bg-white text-slate-800 border-slate-200 hover:border-blue-300 hover:bg-slate-50': form.skin_tone !== tone
                                    }"
                                    class="px-5 py-4 rounded-2xl border transition-all duration-200 font-bold text-base md:text-lg h-24 flex items-center justify-between group shadow-sm">
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
                    <label class="block text-2xl font-bold text-slate-900 mb-8 text-center">Ukuran Tubuh Umum</label>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 md:gap-6">
                        <template x-for="size in ['Slim', 'Medium', 'Plus']">
                            <button @click="form.body_size = size"
                                    :class="{
                                        'bg-gradient-to-br from-blue-600 to-indigo-600 text-white border-transparent ring-2 ring-blue-200': form.body_size === size,
                                        'bg-white text-slate-800 border-slate-200 hover:border-blue-300 hover:bg-slate-50': form.body_size !== size
                                    }"
                                    class="py-7 md:py-8 px-6 rounded-2xl border transition-all duration-200 font-bold text-lg md:text-xl shadow-sm h-24 flex items-center justify-center">
                                <span x-text="size"></span>
                            </button>
                        </template>
                    </div>
                </div>

                 <div x-show="step === 6" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                    <label class="block text-2xl font-bold text-slate-900 mb-8 text-center">Warna Dominan di Lemari</label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 md:gap-5">
                        <template x-for="color in ['Hitam', 'Putih', 'Abu-abu', 'Biru', 'Merah', 'Hijau', 'Kuning', 'Pink', 'Coklat']">
                            <button @click="form.favorite_color = color"
                                    :class="{
                                        'bg-gradient-to-br from-blue-600 to-indigo-600 text-white border-transparent ring-2 ring-blue-200': form.favorite_color === color,
                                        'bg-white text-slate-800 border-slate-200 hover:border-blue-300 hover:bg-slate-50': form.favorite_color !== color
                                    }"
                                    class="py-5 px-6 rounded-2xl border transition-all duration-200 font-bold text-base md:text-lg shadow-sm h-20 flex items-center justify-center">
                                <span x-text="color"></span>
                            </button>
                        </template>
                    </div>
                </div>

                 <div x-show="step === 7" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                    <label class="block text-2xl font-bold text-slate-900 mb-8 text-center">Kebutuhan Utama Berpakaian</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 md:gap-5">
                        <template x-for="need in ['Sehari-hari', 'Kerja / Kantor', 'Kampus', 'Konten Creator', 'Hangout', 'Formal Event']">
                            <button @click="form.main_need = need"
                                    :class="{
                                        'bg-gradient-to-br from-blue-600 to-indigo-600 text-white border-transparent ring-2 ring-blue-200': form.main_need === need,
                                        'bg-white text-slate-800 border-slate-200 hover:border-blue-300 hover:bg-slate-50': form.main_need !== need
                                    }"
                                    class="px-6 rounded-2xl border transition-all duration-200 font-bold text-base md:text-lg h-24 flex items-center justify-center text-center shadow-sm">
                                <span x-text="need"></span>
                            </button>
                        </template>
                    </div>
                </div>
            </div>
            <div class="px-6 md:px-12 lg:px-16 py-8 bg-white mt-auto border-t border-slate-100">
                <div class="grid grid-cols-2 gap-4 md:gap-6">
                    
                        <button @click="prevStep"
                            :disabled="step === 1"
                            :class="{'opacity-0 pointer-events-none': step === 1}"
                            class="w-full py-4 md:py-5 rounded-2xl bg-slate-100 text-slate-800 font-extrabold text-base md:text-lg hover:bg-slate-200 transition-colors tracking-wide">
                        Kembali
                    </button>

                        <button @click="nextStep"
                            x-show="step < totalSteps"
                            :disabled="!canProceed"
                            :class="{'bg-gradient-to-r from-blue-600 to-indigo-600 hover:opacity-95 text-white shadow-lg shadow-blue-500/30': canProceed, 
                                 'bg-gray-200 text-gray-400 cursor-not-allowed': !canProceed}"
                            class="w-full py-4 md:py-5 rounded-2xl font-extrabold text-base md:text-lg transition-all tracking-wide">
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
                                :class="{'bg-gradient-to-r from-blue-600 to-indigo-600 hover:opacity-95 text-white shadow-lg shadow-blue-500/30': canProceed, 
                                         'bg-gray-200 text-gray-400 cursor-not-allowed': !canProceed}"
                                class="w-full py-4 md:py-5 rounded-2xl font-extrabold text-base md:text-lg transition-all tracking-wide flex items-center justify-center gap-2">
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