<div
    x-show="loading"
    x-transition:leave="transition-opacity duration-300"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-[9999] flex items-center justify-center overflow-hidden bg-white"
>

    {{-- BACKGROUND --}}
    <div class="absolute inset-0 pointer-events-none">

        {{-- Soft background --}}
        <div
            class="absolute inset-0
                   bg-[radial-gradient(circle_at_center,#f3e8ff_0%,#ffffff_55%)]"
        ></div>

        {{-- Grid --}}
        <div
            class="absolute inset-0 opacity-20
                   bg-[linear-gradient(#e9d5ff_1px,transparent_1px),linear-gradient(90deg,#e9d5ff_1px,transparent_1px)]
                   [background-size:40px_40px]"
        ></div>

    </div>


    {{-- MAIN --}}
    <div class="relative flex flex-col items-center">

        {{-- =================================================
             CIRCULAR LOADER
        ================================================== --}}
        <div class="relative flex items-center justify-center w-44 h-44">


            {{-- Outer subtle ring --}}
            <div
                class="absolute inset-0
                       rounded-full
                       border
                       border-purple-100"
            ></div>


            {{-- Main spinner --}}
            <div
                class="absolute inset-0
                       rounded-full
                       border-[3px]
                       border-purple-100
                       border-t-purple-700
                       border-r-purple-500
                       animate-[spin_1.3s_linear_infinite]"
            ></div>


            {{-- Second spinner --}}
            <div
                class="absolute inset-[9px]
                       rounded-full
                       border-2
                       border-dashed
                       border-purple-200
                       animate-[spin_3s_linear_infinite_reverse]"
            ></div>


            {{-- Small rotating ring --}}
            <div
                class="absolute inset-[18px]
                       rounded-full
                       border
                       border-purple-200/60
                       animate-[spin_4s_linear_infinite]"
            ></div>


            {{-- =================================================
                 LOGO
                 TIADA BACKGROUND PUTIH
            ================================================== --}}
            <div
                class="relative
                       flex
                       items-center
                       justify-center
                       animate-[logoReveal_1s_ease-out]"
            >

                <img
                    src="{{ asset('asset/logo.PNG') }}"
                    alt="Logo Kementerian"
                    class="h-24 w-24 object-contain
                           drop-shadow-[0_8px_18px_rgba(88,28,135,0.15)]"
                >

            </div>

        </div>


        {{-- BRAND --}}
        <div class="mt-9 text-center">

            <h2
                class="text-xl
                       font-bold
                       tracking-wide
                       text-purple-900
                       animate-[fadeUp_0.8s_ease-out]"
            >
                Laporan Pegawai Bertugas
            </h2>

            <p
                class="mt-2
                       text-xs
                       font-medium
                       tracking-[0.2em]
                       uppercase
                       text-gray-400"
            >
                Kementerian Perpaduan Negara
            </p>

        </div>


        {{-- STATUS --}}
        <div class="mt-6 flex items-center gap-2">

            <span
                class="w-1.5 h-1.5
                       rounded-full
                       bg-purple-700
                       animate-pulse"
            ></span>

            <p
                class="text-[11px]
                       font-medium
                       text-gray-400"
            >
                Memuatkan sistem...
            </p>

        </div>

    </div>

</div>


<style>

/* =========================================================
   LOGO REVEAL
========================================================= */

@keyframes logoReveal {

    0% {
        opacity: 0;
        transform: scale(0.65);
    }

    70% {
        opacity: 1;
        transform: scale(1.05);
    }

    100% {
        opacity: 1;
        transform: scale(1);
    }

}


/* =========================================================
   TEXT FADE UP
========================================================= */

@keyframes fadeUp {

    0% {
        opacity: 0;
        transform: translateY(10px);
    }

    100% {
        opacity: 1;
        transform: translateY(0);
    }

}

</style>
