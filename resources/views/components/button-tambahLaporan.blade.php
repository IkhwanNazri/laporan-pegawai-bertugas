
                @if(Auth::user()->role === 'pegawai_bertugas' || Auth::user()->role === 'pegawaibertugas')
                    <div class="pb-1">
                        <a href="{{ route('user.jadual.index') }}" class="inline-flex items-center justify-center px-5 py-2.5 mb-6 bg-purple-900 text-white text-sm font-medium rounded-full hover:bg-purple-800 transition-all shadow-md whitespace-nowrap">
                            + Tambah Laporan
                        </a>
                    </div>
                @endif
                @if(Auth::user()->role === 'pegawai_keselamatan_aras' || Auth::user()->role === 'pka')
                    <div class="pb-1">
                        <a href="{{ route('pka.jadual.index') }}" class="inline-flex items-center justify-center px-5 py-2.5 mb-6 bg-purple-900 text-white text-sm font-medium rounded-full hover:bg-purple-800 transition-all shadow-md whitespace-nowrap">
                            + Tambah Laporan
                        </a>
                    </div>
                @endif
