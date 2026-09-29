<div
    x-data="{
        open: false,
        jadual: {},
        show(data) {
            this.jadual = data;
            this.open = true;
            document.body.classList.add('overflow-hidden');
        },
        close() {
            this.open = false;
            document.body.classList.remove('overflow-hidden');
        }
    }"
    @open-jadual.window="show($event.detail)"
    @keydown.escape.window="close()"
>
    <div x-show="open" x-cloak class="fixed inset-0 z-[9999] overflow-y-auto">
        <div
            x-show="open"
            x-transition.opacity
            @click="close()"
            class="fixed inset-0 bg-black/50 backdrop-blur-sm"
        ></div>

        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div
                x-show="open"
                x-transition
                @click.stop
                class="relative w-full max-w-2xl bg-white rounded-2xl shadow-2xl overflow-hidden"
            >
                <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">
                            Maklumat Jadual Bertugas
                        </h2>
                        <p class="text-sm text-gray-500 mt-1" x-text="jadual.tarikh"></p>
                    </div>

                    <button
                        type="button"
                        @click="close()"
                        class="p-2 text-gray-400 hover:text-gray-700 hover:bg-gray-100 rounded-full transition"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-width="2" stroke-linecap="round" d="M6 6l12 12M18 6L6 18"/>
                        </svg>
                    </button>
                </div>

                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase mb-1">Tarikh</p>
                            <p class="text-sm font-semibold text-gray-800" x-text="jadual.tarikh"></p>
                        </div>

                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase mb-1">Bahagian</p>
                            <p class="text-sm font-semibold text-gray-800" x-text="jadual.bahagian"></p>
                        </div>

                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase mb-1">Aras</p>
                            <p class="text-sm font-semibold text-gray-800" x-text="'Aras ' + jadual.aras"></p>
                        </div>

                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase mb-1">No. Telefon</p>
                            <p class="text-sm font-semibold text-gray-800" x-text="jadual.telefon"></p>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 pt-5">
                        <h3 class="text-sm font-bold text-gray-900 mb-4">
                            Pegawai Bertugas
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase mb-1">Nama</p>
                                <p class="text-sm font-semibold text-purple-900" x-text="jadual.pegawai"></p>
                            </div>

                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase mb-1">Emel</p>
                                <p class="text-sm font-semibold text-gray-800 break-all" x-text="jadual.email"></p>
                            </div>
                        </div>
                    </div>

                    <div x-show="jadual.pengganti" x-cloak class="border-t border-gray-100 pt-5">
                        <h3 class="text-sm font-bold text-gray-900 mb-4">
                            Pegawai Pengganti
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase mb-1">Nama</p>
                                <p class="text-sm font-semibold text-emerald-700" x-text="jadual.pengganti"></p>
                            </div>

                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase mb-1">Emel</p>
                                <p class="text-sm font-semibold text-gray-800 break-all" x-text="jadual.emailPengganti || '-'"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end px-6 py-4 bg-gray-50 border-t border-gray-100">
                    <button
                        type="button"
                        @click="close()"
                        class="px-5 py-2 bg-gray-800 text-white text-sm font-medium rounded-full hover:bg-gray-900 transition"
                    >
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
[x-cloak] {
    display: none !important;
}
</style>
