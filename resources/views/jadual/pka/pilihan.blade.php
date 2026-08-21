<x-app-layout>
    <div class="py-8 min-h-screen bg-[radial-gradient(#cbd5e1_1px,transparent_1px)] [background-size:20px_20px] flex flex-col justify-between">
        <div class="max-w-full px-4 sm:px-6 lg:px-8 space-y-6">


            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-3">
                 <div class="w-full">
                    <x-page-header class="" title="Jadual Sistem Pegawai Bertugas" :breadcrumbs="['Jadual' => '#']" />
                </div>
            </div>


            @if(session('success'))
                <div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg text-sm font-semibold">
                    {{ session('success') }}
                </div>
            @endif


            <div class="flex flex-col md:flex-row items-center justify-center gap-8 pt-6 pb-12">


                <a href="{{ route('pka.jadual.harian') }}" class="group cursor-pointer transform transition-all duration-500 hover:scale-105 hover:-rotate-1">
                    <div class="text-slate-800 rounded-3xl border border-purple-100 bg-white shadow-xl duration-700 z-10 relative overflow-hidden hover:border-purple-300 hover:shadow-purple-200/50 hover:shadow-2xl w-[340px] sm:w-[360px]">


                        <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
                            <div class="absolute inset-0 bg-gradient-to-tr from-purple-50/80 to-purple-100/30 opacity-60 group-hover:opacity-100 transition-opacity duration-500"></div>
                            <div style="animation-delay: 0.5s;" class="absolute -bottom-20 -left-20 w-48 h-48 rounded-full bg-gradient-to-tr from-purple-300/40 to-transparent blur-2xl opacity-50 group-hover:opacity-80 transform group-hover:scale-110 transition-all duration-700 animate-bounce"></div>
                            <div class="absolute top-10 left-10 w-16 h-16 rounded-full bg-purple-200/30 blur-xl animate-ping"></div>
                            <div style="animation-delay: 1s;" class="absolute bottom-16 right-16 w-12 h-12 rounded-full bg-purple-200/30 blur-lg animate-ping"></div>
                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/80 to-transparent transform -skew-x-12 translate-x-full group-hover:translate-x-[-200%] transition-transform duration-1000"></div>
                        </div>

                        <!-- Kandungan Kad -->
                        <div class="p-8 relative z-10">
                            <div class="flex flex-col items-center text-center">

                                <!-- Ikon Bulat Animasi -->
                                <div class="relative mb-6">
                                    <div class="absolute inset-0 rounded-full border-2 border-purple-300 animate-ping"></div>
                                    <div style="animation-delay: 0.5s;" class="absolute inset-0 rounded-full border border-purple-200 animate-pulse"></div>

                                    <div class="p-6 rounded-full border border-purple-200 bg-gradient-to-br from-purple-900 to-purple-800 text-white shadow-lg transform group-hover:rotate-12 group-hover:scale-110 transition-all duration-500">
                                        <div class="transform group-hover:rotate-12 transition-transform duration-700">
                                           <x-heroicon-s-calendar-days class="w-10 h-10"></x-heroicon-s-calendar-days>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tajuk -->
                                <div class="mb-3 transform group-hover:scale-105 transition-transform duration-300">
                                    <p class="text-2xl font-black text-purple-950 tracking-wider uppercase">
                                        Jadual Harian
                                    </p>
                                </div>

                                <!-- Penerangan Ringkas -->
                                <div class="space-y-1 max-w-sm">
                                    <p class="text-slate-700 text-sm font-semibold leading-relaxed">
                                        Tetapkan tugasan harian
                                    </p>
                                    <p class="text-slate-500 text-xs leading-relaxed">
                                        secara spesifik mengikut tarikh,
                                    </p>
                                    <p class="text-slate-500 text-xs leading-relaxed">
                                        bahagian, aras dan pegawai bertugas
                                    </p>
                                    <p class="text-slate-500 text-xs leading-relaxed">
                                        untuk kawalan keselamatan.
                                    </p>
                                </div>

                                <!-- Garis Pembahagi Animasi -->
                                <div class="mt-6 w-1/3 h-0.5 bg-gradient-to-r from-transparent via-purple-400 to-transparent rounded-full transform group-hover:w-1/2 group-hover:h-1 transition-all duration-500 animate-pulse"></div>

                                <!-- Tiga Titik Animasi Bounce -->
                                <div class="flex space-x-2 mt-4 opacity-70 group-hover:opacity-100 transition-opacity duration-300">
                                    <div class="w-2 h-2 bg-purple-600 rounded-full animate-bounce"></div>
                                    <div style="animation-delay: 0.1s;" class="w-2 h-2 bg-purple-600 rounded-full animate-bounce"></div>
                                    <div style="animation-delay: 0.2s;" class="w-2 h-2 bg-purple-600 rounded-full animate-bounce"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Hiasan Bucu Kad -->
                        <div class="absolute top-0 left-0 w-20 h-20 bg-gradient-to-br from-purple-200/50 to-transparent rounded-br-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="absolute bottom-0 right-0 w-20 h-20 bg-gradient-to-tl from-purple-200/50 to-transparent rounded-tl-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    </div>
                </a>



                <a href="{{ route('pka.jadual.mingguan') }}" class="group cursor-pointer transform transition-all duration-500 hover:scale-105 hover:rotate-1">
                    <div class="text-slate-800 rounded-3xl border border-emerald-100 bg-white shadow-xl duration-700 z-10 relative overflow-hidden hover:border-emerald-300 hover:shadow-emerald-200/50 hover:shadow-2xl w-[340px] sm:w-[360px]">

                        <!-- Effect Latar Belakang Kad -->
                        <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
                            <div class="absolute inset-0 bg-gradient-to-tr from-emerald-50/80 to-emerald-100/30 opacity-60 group-hover:opacity-100 transition-opacity duration-500"></div>
                            <div style="animation-delay: 0.5s;" class="absolute -bottom-20 -left-20 w-48 h-48 rounded-full bg-gradient-to-tr from-emerald-300/40 to-transparent blur-2xl opacity-50 group-hover:opacity-80 transform group-hover:scale-110 transition-all duration-700 animate-bounce"></div>
                            <div class="absolute top-10 left-10 w-16 h-16 rounded-full bg-emerald-200/30 blur-xl animate-ping"></div>
                            <div style="animation-delay: 1s;" class="absolute bottom-16 right-16 w-12 h-12 rounded-full bg-emerald-200/30 blur-lg animate-ping"></div>
                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/80 to-transparent transform -skew-x-12 translate-x-full group-hover:translate-x-[-200%] transition-transform duration-1000"></div>
                        </div>

                        <!-- Kandungan Kad -->
                        <div class="p-8 relative z-10">
                            <div class="flex flex-col items-center text-center">

                                <!-- Ikon Bulat Animasi -->
                                <div class="relative mb-6">
                                    <div class="absolute inset-0 rounded-full border-2 border-emerald-300 animate-ping"></div>
                                    <div style="animation-delay: 0.5s;" class="absolute inset-0 rounded-full border border-emerald-200 animate-pulse"></div>

                                    <div class="p-6 rounded-full border border-emerald-200 bg-gradient-to-br from-emerald-800 to-emerald-700 text-white shadow-lg transform group-hover:rotate-12 group-hover:scale-110 transition-all duration-500">
                                        <div class="transform group-hover:rotate-180 transition-transform duration-700">
                                            <!-- Ikon Kalendar Mingguan -->
                                            <x-heroicon-s-rectangle-stack class="w-10 h-10"></x-heroicon-s-rectangle-stack>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tajuk -->
                                <div class="mb-3 transform group-hover:scale-105 transition-transform duration-300">
                                    <p class="text-2xl font-black text-emerald-950 tracking-wider uppercase">
                                        Jadual Mingguan
                                    </p>
                                </div>

                                <!-- Penerangan Ringkas -->
                                <div class="space-y-1 max-w-sm">
                                    <p class="text-slate-700 text-sm font-semibold leading-relaxed">
                                        Penjadualan secara bertempoh
                                    </p>
                                    <p class="text-slate-500 text-xs leading-relaxed">
                                        untuk giliran mingguan,
                                    </p>
                                    <p class="text-slate-500 text-xs leading-relaxed">
                                        memudahkan pemantauan berkala
                                    </p>
                                    <p class="text-slate-500 text-xs leading-relaxed">
                                        dan susunan jadual jangka panjang.
                                    </p>
                                </div>

                                <!-- Garis Pembahagi Animasi -->
                                <div class="mt-6 w-1/3 h-0.5 bg-gradient-to-r from-transparent via-emerald-400 to-transparent rounded-full transform group-hover:w-1/2 group-hover:h-1 transition-all duration-500 animate-pulse"></div>

                                <!-- Tiga Titik Animasi Bounce -->
                                <div class="flex space-x-2 mt-4 opacity-70 group-hover:opacity-100 transition-opacity duration-300">
                                    <div class="w-2 h-2 bg-emerald-600 rounded-full animate-bounce"></div>
                                    <div style="animation-delay: 0.1s;" class="w-2 h-2 bg-emerald-600 rounded-full animate-bounce"></div>
                                    <div style="animation-delay: 0.2s;" class="w-2 h-2 bg-emerald-600 rounded-full animate-bounce"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Hiasan Bucu Kad -->
                        <div class="absolute top-0 left-0 w-20 h-20 bg-gradient-to-br from-emerald-200/50 to-transparent rounded-br-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="absolute bottom-0 right-0 w-20 h-20 bg-gradient-to-tl from-emerald-200/50 to-transparent rounded-tl-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    </div>
                </a>

            </div>
        </div>
    </div>
    <x-footer></x-footer>
</x-app-layout>
