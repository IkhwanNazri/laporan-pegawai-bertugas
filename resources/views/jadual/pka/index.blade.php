<x-app-layout>
    <div class="py-8 min-h-screen bg-[radial-gradient(#cbd5e1_1px,transparent_1px)] [background-size:20px_20px]">
        <div class="max-w-full px-4 sm:px-6 lg:px-8 space-y-6">

            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-3">
                <div class="w-full">
                    <x-page-header title="Jadual Sistem Pegawai Bertugas" :breadcrumbs="['Jadual' => '#']" />
                </div>

                <div class="flex items-center gap-3 w-full sm:w-auto mb-4">
                    <a href="#" class="inline-flex items-center justify-center px-4 py-2.5 bg-red-600 text-white text-sm font-medium rounded-full hover:bg-red-700 transition-all shadow-md whitespace-nowrap mb-4">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Export PDF
                    </a>

                    <a href="{{ route('pka.jadual.pilihan') }}" class="inline-flex items-center justify-center px-5 py-2.5 mb-4 bg-purple-900 text-white text-sm font-medium rounded-full hover:bg-purple-800 transition-all shadow-md whitespace-nowrap">
                        + Tambah Jadual
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg text-sm font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg text-sm font-semibold">
                    {{ session('error') }}
                </div>
            @endif





            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-6 bg-purple-600 rounded-full"></div>
                            <h3 class="text-base font-bold text-gray-800 uppercase font-['Poppins']">
                                Jadual Bulanan
                            </h3>
                            <span class="text-sm font-semibold text-purple-900 tracking-widest rounded-full bg-purple-100 hover::bg-red-500 border-2 border-slate-200  px-5 py-2 uppercase font-['Poppins']">
                                {{ now()->locale('ms')->translatedFormat('F') }}
                            </span>
                        </div>

                        <div class="flex items-center gap-4">
                            <form id="bulkEmailForm" action="{{ route('pka.jadual.bulk-email') }}" method="POST">
                                @csrf
                            </form>

                            <button
                                type="button"
                                id="bulkEmailButton"
                                class="text-purple-800 hover:text-purple-700 transition"
                                title="Pilih Emel"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                    <path d="M1.5 8.67v8.58a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V8.67l-8.928 5.493a3 3 0 0 1-3.144 0L1.5 8.67Z"/>
                                    <path d="M22.5 6.908V6.75a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3v.158l9.714 5.978a1.5 1.5 0 0 0 1.572 0L22.5 6.908Z"/>
                                </svg>
                            </button>

                            <form id="bulkDeleteForm" action="{{ route('pka.jadual.bulk-delete') }}" method="POST">
                                @csrf
                            </form>

                            <button
                                type="button"
                                id="bulkDeleteButton"
                                class="text-red-600 hover:text-red-700 transition"
                                title="Padam Jadual Dipilih"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                    <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 1 0 1.5.058l.345-9Z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                <div class="overflow-x-auto border border-gray-200 rounded-lg">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-200 text-xs text-gray-600 uppercase bg-gray-100/50">
                                <th class="p-3 w-10">
                                    <input type="checkbox" id="selectAllHarian" class="rounded border-gray-300 text-purple-600">
                                </th>
                                <th class="p-3 w-32">Tarikh</th>
                                <th class="p-3 w-32">Hari</th>
                                <th class="p-3 w-32"></th>
                                <th class="p-3">Nama</th>
                                <th class="p-3">Emel</th>
                                <th class="p-3 text-center w-32">Hantar Emel</th>
                                <th class="p-3 text-center w-28">Tindakan</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 text-sm">
                            @forelse($jaduals as $jadual)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3">
                                        <input type="checkbox" value="{{ $jadual->id }}" class="jadual-checkbox rounded border-gray-300 text-purple-600">
                                    </td>

                                    <td class="p-3 font-semibold whitespace-nowrap">
                                        @if(strtolower($jadual->jenis ?? '') === 'mingguan')
                                            {{ \Carbon\Carbon::parse($jadual->tarikh_mula)->format('d/m/Y') }}
                                            -
                                            {{ \Carbon\Carbon::parse($jadual->tarikh_tamat)->format('d/m/Y') }}
                                        @else
                                            {{ \Carbon\Carbon::parse($jadual->tarikh)->format('d/m/Y') }}
                                        @endif
                                    </td>

                                   <td class="p-3 whitespace-nowrap">
                                    @if(strtolower($jadual->jenis ?? '') === 'mingguan')
                                        {{ \Carbon\Carbon::parse($jadual->tarikh_mula)->locale('ms')->translatedFormat('l') }}
                                        -
                                        {{ \Carbon\Carbon::parse($jadual->tarikh_tamat)->locale('ms')->translatedFormat('l') }}
                                    @else
                                        {{ \Carbon\Carbon::parse($jadual->tarikh)->locale('ms')->translatedFormat('l') }}
                                    @endif
                                </td>
                                    <td class="p-3">

                                    </td>

                                    <td class="p-3 font-bold text-purple-900">
                                        {{ $jadual->pegawai->name ?? '-' }}
                                    </td>

                                    <td class="p-3 text-gray-600">
                                        {{ $jadual->pegawai->email ?? '-' }}
                                    </td>

                                    <td class="p-3 text-center">
                                        @if($jadual->pegawai?->email)
                                            <form action="{{ route('pka.jadual.reminder', $jadual->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="px-3 py-1 bg-purple-700 text-white text-xs rounded-full hover:bg-purple-800 transition">
                                                    Hantar
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-400 text-xs">Tiada Emel</span>
                                        @endif
                                    </td>

                                    <td class="p-3 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <button
                                                type="button"
                                                @click="$dispatch('open-jadual', @js([
                                                    'tarikh' => \Carbon\Carbon::parse($jadual->tarikh)->format('d/m/Y'),
                                                    'bahagian' => $jadual->bahagian->kod_bahagian ?? '-',
                                                    'aras' => $jadual->aras,
                                                    'telefon' => $jadual->no_telefon ?? '-',
                                                    'pegawai' => $jadual->pegawai->name ?? '-',
                                                    'email' => $jadual->pegawai->email ?? '-',
                                                    'pengganti' => $jadual->pegawaiGanti->name ?? '',
                                                    'emailPengganti' => $jadual->pegawaiGanti->email ?? ''
                                                ]))"
                                                class="p-1.5 text-gray-600 hover:text-purple-700 hover:bg-purple-50 rounded-lg transition"
                                                title="Lihat"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                                </svg>
                                            </button>

                                            <a href="{{ route('pka.jadual.edit', $jadual->id) }}" class="p-1.5 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-5m-1.414-9.414a2 2 0 1 1 2.828 2.828L11.828 15H9v-2.828l8.586-8.586Z"/>
                                                </svg>
                                            </a>

                                            <form action="{{ route('pka.jadual.destroy', $jadual->id) }}" method="POST" onsubmit="return confirm('Adakah anda pasti untuk memadam jadual ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition" title="Padam">
                                                   <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
</svg>

                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-6 text-center text-gray-400 font-medium">
                                        Tiada rekod jadual harian ditemui.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100 p-6">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-2 h-6 bg-emerald-500 rounded-full"></div>
                    <h3 class="text-base font-bold text-gray-800 uppercase">Jadual Bertugas (Mingguan)</h3>
                </div>

                <div class="overflow-x-auto border border-gray-200 rounded-lg">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-200 text-xs text-gray-600 uppercase bg-gray-100/50">
                                <th class="p-3 w-32">Tarikh</th>
                                <th class="p-3 w-32">Hari</th>
                                <th class="p-3">Nama</th>
                                <th class="p-3">Emel</th>
                                <th class="p-3 text-center w-32">Hantar Emel</th>
                                <th class="p-3 text-center w-28">Tindakan</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 text-sm">
                            @forelse($jadualMingguan as $jadual)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 font-semibold">
                                        {{ \Carbon\Carbon::parse($jadual->tarikh)->format('d/m/Y') }}
                                    </td>

                                    <td class="p-3">
                                        {{ \Carbon\Carbon::parse($jadual->tarikh)->locale('ms')->translatedFormat('l') }}
                                    </td>

                                    <td class="p-3 font-bold text-emerald-700">
                                        {{ $jadual->pegawai->name ?? '-' }}
                                    </td>

                                    <td class="p-3 text-gray-600">
                                        {{ $jadual->pegawai->email ?? '-' }}
                                    </td>

                                    <td class="p-3 text-center">
                                        @if($jadual->pegawai?->email)
                                            <form action="{{ route('pka.jadual.reminder', $jadual->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="px-3 py-1 bg-emerald-600 text-white text-xs rounded-full hover:bg-emerald-700 transition">
                                                    Hantar
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-400 text-xs">Tiada Emel</span>
                                        @endif
                                    </td>

                                    <td class="p-3 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <button
                                                type="button"
                                                @click="$dispatch('open-jadual', @js([
                                                    'tarikh' => \Carbon\Carbon::parse($jadual->tarikh)->format('d/m/Y'),
                                                    'bahagian' => $jadual->bahagian->kod_bahagian ?? '-',
                                                    'aras' => $jadual->aras,
                                                    'telefon' => $jadual->no_telefon ?? '-',
                                                    'pegawai' => $jadual->pegawai->name ?? '-',
                                                    'email' => $jadual->pegawai->email ?? '-',
                                                    'pengganti' => $jadual->pegawaiGanti->name ?? '',
                                                    'emailPengganti' => $jadual->pegawaiGanti->email ?? ''
                                                ]))"
                                                class="p-1.5 text-gray-600 hover:text-emerald-700 hover:bg-emerald-50 rounded-lg transition"
                                                title="Lihat"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                                </svg>
                                            </button>

                                            <a href="{{ route('pka.jadual.edit', $jadual->id) }}" class="p-1.5 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-5m-1.414-9.414a2 2 0 1 1 2.828 2.828L11.828 15H9v-2.828l8.586-8.586Z"/>
                                                </svg>
                                            </a>

                                            <form action="{{ route('pka.jadual.destroy', $jadual->id) }}" method="POST" onsubmit="return confirm('Adakah anda pasti untuk memadam jadual ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition" title="Padam">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
</svg>

                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-6 text-center text-gray-400 font-medium">
                                        Tiada rekod jadual mingguan ditemui.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div> --}}

            <div class="mt-4 pb-8">
                {{ $jaduals->links() }}
            </div>

        </div>
    </div>
    <x-sweet-alert />

    <x-footer />
    <x-modal-jadual />
</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded',function(){
const emailButton=document.getElementById('bulkEmailButton');
const deleteButton=document.getElementById('bulkDeleteButton');
const selectAll=document.getElementById('selectAllHarian');

selectAll?.addEventListener('change',function(){
document.querySelectorAll('.jadual-checkbox').forEach(checkbox=>{
checkbox.checked=this.checked;
});
});

function getSelectedIds(){
return [...document.querySelectorAll('.jadual-checkbox:checked')].map(checkbox=>checkbox.value);
}

function addIdsToForm(form,ids){
form.querySelectorAll('.bulk-id').forEach(input=>input.remove());
ids.forEach(id=>{
const input=document.createElement('input');
input.type='hidden';
input.name='ids[]';
input.value=id;
input.classList.add('bulk-id');
form.appendChild(input);
});
}

emailButton?.addEventListener('click',function(){
const ids=getSelectedIds();

if(ids.length===0){
window.dispatchEvent(new CustomEvent('open-alert',{
detail:{
type:'email',
title:'Tiada jadual dipilih',
message:'Sila pilih sekurang-kurangnya satu jadual terlebih dahulu.',
confirmText:'Faham'
}
}));
return;
}

const form=document.getElementById('bulkEmailForm');
addIdsToForm(form,ids);

window.dispatchEvent(new CustomEvent('open-alert',{
detail:{
type:'email',
title:'Hantar emel?',
message:`Hantar emel kepada ${ids.length} pegawai yang dipilih?`,
form:form,
confirmText:'Ya, hantar'
}
}));
});

deleteButton?.addEventListener('click',function(){
const ids=getSelectedIds();

if(ids.length===0){
window.dispatchEvent(new CustomEvent('open-alert',{
detail:{
type:'warning',
title:'Tiada jadual dipilih',
message:'Sila pilih sekurang-kurangnya satu jadual terlebih dahulu.',
confirmText:'Faham'
}
}));
return;
}

const form=document.getElementById('bulkDeleteForm');
addIdsToForm(form,ids);

window.dispatchEvent(new CustomEvent('open-alert',{
detail:{
type:'warning',
title:'Padam jadual?',
message:`Anda pasti mahu memadam ${ids.length} jadual yang dipilih?`,
form:form,
confirmText:'Ya, padam'
}
}));
});
});
</script>
