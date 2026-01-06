<x-layout>
    <x-slot:title>Aplikasi Pending - ScanFit</x-slot:title>

    <div class="min-h-screen bg-slate-50">
        <!-- Header -->
        <section class="relative overflow-hidden bg-white pb-12 pt-48 border-b border-slate-200">
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-orange-50 rounded-full blur-3xl opacity-60 -mr-20 -mt-20 pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="space-y-4 text-center md:text-left">
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                        Aplikasi Anda <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-600 to-red-600">Dalam Review</span>
                    </h1>
                    <p class="text-base text-slate-600 max-w-2xl">
                        Terima kasih telah mendaftar sebagai Brand Partner ScanFit. Tim kami sedang mereview aplikasi Anda dengan seksama.
                    </p>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <!-- Sidebar Info -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Info Card -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                        <h3 class="font-bold text-slate-900 mb-4">Informasi Penting</h3>
                        <div class="space-y-4 text-sm">
                            <div>
                                <p class="text-xs font-bold text-slate-600 uppercase mb-1">Waktu Review</p>
                                <p class="font-bold text-slate-900">2-3 Hari Kerja</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-600 uppercase mb-1">Notifikasi</p>
                                <p class="text-slate-700 text-xs truncate">{{ auth()->user()->email }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-600 uppercase mb-1">Status</p>
                                <span class="inline-block px-3 py-1.5 bg-orange-100 text-orange-700 font-bold rounded-full text-xs">⏳ PENDING</span>
                            </div>
                        </div>
                    </div>

                    <!-- WhatsApp Support -->
                    <div class="bg-emerald-50 rounded-2xl border border-emerald-200 p-6">
                        <h3 class="font-bold text-emerald-900 mb-3">Ada Pertanyaan?</h3>
                        <p class="text-emerald-800 text-sm mb-4">Hubungi tim support kami untuk konsultasi lebih lanjut.</p>
                        <a href="https://wa.me/6281234567890?text=Halo,%20saya%20sudah%20mendaftar%20sebagai%20Brand%20Partner%20ScanFit%20dan%20ingin%20menanyakan%20status%20aplikasi%20saya" target="_blank" class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-emerald-600 text-white font-bold rounded-full hover:bg-emerald-700 transition text-sm">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.272-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.67-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.076 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421-7.403h-.004a9.87 9.87 0 00-5.031 1.378c-3.055 2.364-5.002 5.923-5.002 9.857 0 .954.129 1.895.38 2.813l.102.314-.333 1.71 1.752-.357.115.046c.896.41 1.896.645 2.944.645 5.009 0 9.131-4.122 9.131-9.131 0-2.213-.784-4.313-2.209-5.974a9.78 9.78 0 00-1.749-1.538zm11.249-7.52c-5.509 0-9.998 4.487-9.998 9.996 0 1.794.478 3.549 1.385 5.122L0 24l5.147-1.345c1.458.792 3.157 1.208 4.88 1.208 5.51 0 10-4.487 10-9.996 0-5.509-4.49-9.989-9.999-9.989z"/></svg>
                            Chat Support
                        </a>
                    </div>

                    <!-- FAQ -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                        <h3 class="font-bold text-slate-900 mb-3 text-base">FAQ</h3>
                        <details class="text-sm cursor-pointer">
                            <summary class="font-bold text-slate-900 hover:text-slate-700 mb-2">Ada biaya?</summary>
                            <p class="text-slate-600 text-xs">Tidak ada! Gratis dan tanpa komisi apapun.</p>
                        </details>
                        <details class="text-sm cursor-pointer mt-3">
                            <summary class="font-bold text-slate-900 hover:text-slate-700 mb-2">Freemium?</summary>
                            <p class="text-slate-600 text-xs">Akan diluncurkan nanti dengan benefit eksklusif untuk partner.</p>
                        </details>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="lg:col-span-3 space-y-6">
                    <!-- Status Timeline -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-8 shadow-sm">
                        <h2 class="text-xl font-bold text-slate-900 mb-6">Status Aplikasi</h2>

                        <div class="space-y-4">
                            <!-- Step 1: Completed -->
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-10 w-10 rounded-full bg-emerald-100">
                                        <svg class="h-6 w-6 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h3 class="font-bold text-slate-900">Pendaftaran Selesai</h3>
                                    <p class="text-slate-600 text-sm">Kami telah menerima aplikasi Anda dengan semua dokumen yang diperlukan.</p>
                                </div>
                            </div>

                            <!-- Step 2: In Progress -->
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-10 w-10 rounded-full bg-orange-100 animate-pulse">
                                        <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h3 class="font-bold text-slate-900">Dalam Review</h3>
                                    <p class="text-slate-600 text-sm">Tim kami sedang mereview informasi brand dan dokumen Anda. Proses ini biasanya memakan waktu 2-3 hari kerja.</p>
                                </div>
                            </div>

                            <!-- Step 3: Pending -->
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-10 w-10 rounded-full bg-slate-100">
                                        <svg class="h-6 w-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h3 class="font-bold text-slate-900">Persetujuan</h3>
                                    <p class="text-slate-600 text-sm">Setelah disetujui, Anda akan menerima notifikasi email dan dapat mulai mengelola produk brand Anda.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tips Card -->
                    <div class="bg-blue-50 rounded-2xl border border-blue-200 p-6">
                        <h3 class="font-bold text-blue-900 mb-3">Tips Mempercepat Approval</h3>
                        <ul class="space-y-2 text-blue-800 text-sm">
                            <li class="flex items-start">
                                <span class="mr-2">✓</span>
                                <span>Pastikan proposal brand Anda detail dan profesional</span>
                            </li>
                            <li class="flex items-start">
                                <span class="mr-2">✓</span>
                                <span>Sertakan foto produk berkualitas tinggi dalam proposal</span>
                            </li>
                            <li class="flex items-start">
                                <span class="mr-2">✓</span>
                                <span>Jika ada pertanyaan, hubungi kami melalui WhatsApp untuk klarifikasi cepat</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <section class="bg-white border-t border-slate-200 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-slate-900 mb-8 text-center">Pertanyaan yang Sering Diajukan</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200">
                        <h3 class="font-bold text-slate-900 mb-2">Apakah ada biaya untuk partnership?</h3>
                        <p class="text-slate-600 text-sm">Tidak ada! Pendaftaran brand partner di ScanFit sepenuhnya gratis dan tidak ada komisi apapun.</p>
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200">
                        <h3 class="font-bold text-slate-900 mb-2">Berapa lama review aplikasi?</h3>
                        <p class="text-slate-600 text-sm">Biasanya kami review dalam 2-3 hari kerja. Tim akan menghubungi Anda jika ada pertanyaan atau klarifikasi yang diperlukan.</p>
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200">
                        <h3 class="font-bold text-slate-900 mb-2">Apa yang terjadi setelah disetujui?</h3>
                        <p class="text-slate-600 text-sm">Anda akan mendapat akses dashboard admin untuk upload produk, lihat analytics, dan manage semua informasi brand Anda.</p>
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200">
                        <h3 class="font-bold text-slate-900 mb-2">Apa itu fitur freemium?</h3>
                        <p class="text-slate-600 text-sm">Kami sedang mengembangkan fitur freemium yang akan memberikan benefit eksklusif untuk brand partner loyal. Detail akan dikirim setelah approval.</p>
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200">
                        <h3 class="font-bold text-slate-900 mb-2">Bagaimana jika ada pertanyaan saat pending?</h3>
                        <p class="text-slate-600 text-sm">Hubungi kami via WhatsApp! Tim support kami siap membantu dan menjawab semua pertanyaan Anda dengan cepat.</p>
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200">
                        <h3 class="font-bold text-slate-900 mb-2">Bagaimana produk ditampilkan?</h3>
                        <p class="text-slate-600 text-sm">Produk Anda akan muncul di Explore page dan bisa ditemukan pengguna melalui AI search engine kami yang powerful.</p>
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200">
                        <h3 class="font-bold text-slate-900 mb-2">Berapa limit produk yang bisa diupload?</h3>
                        <p class="text-slate-600 text-sm">Tidak ada batasan! Upload sebanyak mungkin produk dari brand Anda dan update kapan saja sesuai kebutuhan.</p>
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200">
                        <h3 class="font-bold text-slate-900 mb-2">Apakah ada support dari tim ScanFit?</h3>
                        <p class="text-slate-600 text-sm">Ya! Tim support kami tersedia 24/7 melalui chat, email, dan WhatsApp untuk membantu dan membimbing Anda.</p>
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200">
                        <h3 class="font-bold text-slate-900 mb-2">Bagaimana analytics dashboard bekerja?</h3>
                        <p class="text-slate-600 text-sm">Dapatkan real-time insights: product views, clicks, wishlist, dan engagement metrics untuk setiap produk Anda.</p>
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200">
                        <h3 class="font-bold text-slate-900 mb-2">Bagaimana jika aplikasi ditolak?</h3>
                        <p class="text-slate-600 text-sm">Kami akan memberikan feedback detail tentang alasannya. Anda bisa revisi dan submit ulang sesuai saran kami.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer Info -->
        <section class="bg-slate-100 border-t border-slate-200 py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <p class="text-slate-600 text-sm">
                    📧 Anda akan menerima email notifikasi ketika aplikasi Anda telah direview
                    <br>
                    <span class="font-bold text-slate-900">Email: {{ auth()->user()->email }}</span>
                </p>
            </div>
        </section>
    </div>
</x-layout>
