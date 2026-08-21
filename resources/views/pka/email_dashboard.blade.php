<x-app-layout>
    <div class="py-6 min-h-screen bg-gray-100">
        <div class="max-w-[95%] mx-auto">

            <!-- HEADER & BUTANG REFRESH -->
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                    <x-heroicon-s-inbox class="w-6 h-6 text-purple-600" /> Peti Masuk E-mel
                </h2>

                <button onclick="window.location.reload();" class="flex items-center gap-2 px-3 py-1.5 text-sm font-semibold text-gray-600 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-purple-50 hover:text-purple-700 hover:border-purple-200 transition-all active:scale-95 group">
                    <x-heroicon-o-arrow-path class="w-4 h-4 group-hover:animate-spin" />
                    Muat Semula
                </button>
            </div>

            <!-- Alpine.js untuk kawal pilihan e-mel -->
            <div x-data="{
                    aktif: null,
                    urlIframe: '{{ route('emails.raw') }}'
                 }"
                 class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex h-[750px]">

                <!-- KOLUM KIRI: SENARAI INBOX DARI DATABASE -->
                <div class="w-1/3 border-r border-gray-200 flex flex-col bg-white">
                    <div class="p-4 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
                        <span class="font-bold text-gray-700 text-sm">Inbox Utama</span>
                        @if(Auth::user()->unreadNotifications->count() > 0)
                            <span class="text-xs bg-purple-100 text-purple-700 px-2.5 py-1 rounded-full font-bold">
                                {{ Auth::user()->unreadNotifications->count() }} Baru
                            </span>
                        @endif
                    </div>

                    <div class="flex-1 overflow-y-auto divide-y divide-gray-100">
                        @forelse($senaraiEmail as $email)
                            <div @click="aktif = '{{ $email->id }}'; urlIframe = '{{ route('emails.raw', $email->id) }}?t=' + new Date().getTime()"
                                 :class="{'bg-purple-50 border-l-4 border-purple-500': aktif === '{{ $email->id }}', 'hover:bg-gray-50 border-l-4 border-transparent': aktif !== '{{ $email->id }}'}"
                                 class="p-4 cursor-pointer transition-colors group flex gap-3">

                                <div class="flex flex-col gap-2 pt-1 {{ $email->unread() ? 'text-purple-400' : 'text-gray-300' }} group-hover:text-purple-500">
                                    <x-heroicon-o-stop class="w-4 h-4" />
                                    <x-heroicon-o-star class="w-4 h-4" />
                                </div>

                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-baseline mb-0.5">
                                        <p class="text-sm truncate {{ $email->unread() ? 'font-bold text-gray-900' : 'text-gray-600' }}">
                                            Sistem PKA
                                        </p>
                                        <p class="text-[10px] {{ $email->unread() ? 'font-bold text-purple-600' : 'text-gray-400' }}">
                                            {{ $email->created_at->diffForHumans(null, true, true) }}
                                        </p>
                                    </div>

                                    <p class="text-xs truncate {{ $email->unread() ? 'font-bold text-gray-800' : 'text-gray-500' }}">
                                        {{ $email->data['tajuk'] ?? 'Pemberitahuan' }}
                                    </p>
                                    <p class="text-xs text-gray-400 truncate mt-0.5">
                                        {{ $email->data['mesej'] ?? 'Sila semak butiran e-mel...' }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center text-gray-400">
                                <x-heroicon-o-inbox class="w-12 h-12 mx-auto mb-2 text-gray-300" />
                                <p class="text-sm">Peti masuk anda kosong.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- KOLUM KANAN: PAPARAN E-MEL (IFRAME) -->
                <div class="w-2/3 bg-gray-50 flex flex-col relative">
                    <div class="p-3 border-b border-gray-200 bg-white flex items-center justify-between h-14">
                        <div class="flex gap-4 text-gray-400">
                            <button class="hover:bg-gray-100 hover:text-gray-600 p-1.5 rounded transition"><x-heroicon-o-archive-box class="w-5 h-5" /></button>
                            <button class="hover:bg-gray-100 hover:text-gray-600 p-1.5 rounded transition"><x-heroicon-o-trash class="w-5 h-5" /></button>
                            <button class="hover:bg-gray-100 hover:text-gray-600 p-1.5 rounded transition"><x-heroicon-o-envelope-open class="w-5 h-5" /></button>
                        </div>
                        <div class="text-xs text-gray-400 font-medium">Paparan Interaktif</div>
                    </div>

                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none" x-show="false" id="loader">
                        <div class="w-8 h-8 border-4 border-purple-200 border-t-purple-600 rounded-full animate-spin"></div>
                    </div>

                    <iframe
                        :src="urlIframe"
                        class="w-full flex-1 border-0 bg-white"
                        onload="document.getElementById('loader').style.display='none'"
                        title="Paparan Sebenar">
                    </iframe>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
