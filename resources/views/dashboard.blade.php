<x-app-layout>
    @php
        $role = Auth::user()->role ?? '';
    @endphp

    @if($role === 'superadmin')
        @includeIf('dashboard.superadmin')

    @elseif($role === 'penolong_pegawai_keselamatan_jabatan')
        @includeIf('dashboard.ppkj')

    @elseif($role === 'pegawai_keselamatan_aras')
        @includeIf('dashboard.pka')

    @else

        <div class="hidden md:block">
            @includeIf('dashboard.user')
        </div>


        <div class="block md:hidden">
            @includeIf('dashboard.user-mobile')
        </div>

    @endif
</x-app-layout>
