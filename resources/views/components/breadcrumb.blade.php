@props(['items'])

<nav class="flex items-center text-sm font-medium text-gray-500 space-x-2 pb-2">
    <a href="{{ route('dashboard') }}" class="hover:text-purple-700 transition-colors flex items-center space-x-1">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
        </svg>
        <span>Utama</span>
    </a>

    @foreach($items as $label => $url)
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>

        @if($loop->last)
            <span class="text-purple-700">{{ $label }}</span>
        @else
            <a href="{{ $url }}" class="hover:text-purple-700 transition-colors">{{ $label }}</a>
        @endif
    @endforeach
</nav>
