
   {{-- @section('title', 'Dashboard | MyStep')

    <x-slot name="header">
    <div class="py-8 min-h-screen bg-[radial-gradient(#cbd5e1_1px,transparent_1px)] [background-size:20px_20px]" >
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <x-banner-atas></x-banner-atas>
            <x-card-dashboard></x-card-dashboard>
            <x-kalender></x-kalender>
        </div>
    </div>

 --}}

@section('title', 'Dashboard | Pegawai Keselamatan Aras')

<x-slot name="header">
    <div class="relative py-8 min-h-screen overflow-hidden bg-[radial-gradient(#bae6fd_1px,transparent_1px)] [background-size:20px_20px] ">

        <div class="relative z-10">
            <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                  {{-- <div class="flex justify-end mb-4">
                    <x-dark-mode-toggle />
                </div> --}}

                <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

                    {{-- KIRI --}}
                    <div class="xl:col-span-2 space-y-10 mt-5">

                        {{-- BANNER --}}
                        <x-banner-atas />

                        {{-- DALAM PROSES + LAPORAN --}}
                        <x-card-dashboard />

                        {{-- MAIN TASK --}}
                        <x-main-task />

                    </div>


                    {{-- KANAN --}}
                    <div class="space-y-5">

                        {{-- CALENDAR --}}
                        <x-kalender />

                        {{-- PEGAWAI BERTUGAS --}}
                        <x-pegawai-bertugas />

                    </div>

                </div>

            </div>
        </div>

    </div>


