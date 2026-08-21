 <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">


                    <div class="relative p-6 rounded-3xl overflow-hidden shadow-md flex flex-col justify-between h-52 border border-purple-200">
                        <img src="https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?q=80&w=800&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover object-right opacity-50" alt="bg">
                        <div class="absolute inset-0 bg-gradient-to-r from-gray-50 via-purple-50 to-white/20"></div>

                        <div class="flex items-center justify-between relative z-10">
                            <div class="w-16 h-16 bg-purple-800 rounded-full flex items-center justify-center shadow-sm">

                                <img src="{{ asset('asset/document.png') }}" alt="" class="p-3 ">
                            </div>


                            <h2 class="text-xl font-extrabold tracking-wider text-white px-4 py-1.5 drop-shadow-sm bg-purple-900 animate-slide-right  ">
                                LAPORAN
                            </h2>
                        </div>

                        <div class="relative z-10">
                            <p class="text-lg font-bold text-purple-600 mb-1">Keseluruhan</p>


                            <div class="flex items-center w-full">

                                <span class="text-5xl font-black text-purple-900 tracking-tighter">
                                    {{ \App\Models\LaporanBertugas::count() }}
                                </span>


                                <div class="flex-1 ml-3 bg-purple-900 -mr-6 py-2 pl-4 rounded-l-lg animate-slide-right">
                                    <span class="text-xl font-extrabold tracking-wider text-white drop-shadow-sm">
                                        Laporan
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="relative p-6 rounded-3xl overflow-hidden shadow-md flex flex-col justify-between h-52 border border-purple-200">
                        <img src="https://images.unsplash.com/photo-1506784983877-45594efa4cbe?q=80&w=800&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover object-right" alt="bg">
                        <div class="absolute inset-0 bg-gradient-to-r from-white via-white/90 to-white/20"></div>

                        <div class="flex items-center justify-between relative z-10">
                            <div class="w-16 h-16 bg-purple-800 rounded-full flex items-center justify-center shadow-sm">
                                <!-- Icon Task / Check -->
                                     <img src="{{ asset('asset/schedule.png') }}" alt="" class="p-3 ">
                            </div>
                            <h2 class="text-xl font-extrabold justify-end tracking-wider text-white  px-4 drop-shadow-sm bg-purple-900 animate-slide-right">JADUAL</h2>
                        </div>

                        <div class="relative z-10">
                            <p class="text-lg font-bold text-purple-600 mb-1">Keseluruhan</p>
                            <div class="flex items-baseline gap-2">
                                <span class="text-5xl font-black text-purple-900 tracking-tighter">{{ \App\Models\Jadual::count() }}</span>
                                <span class="text-xl font-bold text-purple-800">Dalam Tugas</span>
                            </div>
                        </div>
                    </div>


                    <div class="relative p-6 rounded-3xl overflow-hidden shadow-md flex flex-col justify-between h-52 border border-purple-200">
                        <img src="https://images.unsplash.com/photo-1506784365847-bbad939e9335?q=80&w=800&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover object-right" alt="bg">
                        <div class="absolute inset-0 bg-gradient-to-r from-white via-white/90 to-white/20"></div>

                        <div class="flex items-center justify-between relative z-10">
                            <div class="w-16 h-16 bg-purple-800 rounded-full flex items-center justify-center shadow-sm">

                                 <img src="{{ asset('asset/clock.png') }}" alt="" class="p-3 ">
                            </div>
                            <h2 class="text-xl font-extrabold justify-end tracking-wider text-white  px-4 drop-shadow-sm bg-purple-900 animate-slide-right">HARI INI</h2>
                        </div>

                        <div class="relative z-10">
                            <p class="text-lg font-bold text-purple-600 mb-1">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                            <div class="flex items-baseline gap-2">
                                <span class="text-5xl font-black text-purple-900 tracking-tighter">{{ \App\Models\Jadual::whereDate('tarikh', \Carbon\Carbon::today())->count() }}</span>
                                <span class="text-xl font-bold text-purple-800">Bertugas</span>
                            </div>
                        </div>
                    </div>

                </div>
