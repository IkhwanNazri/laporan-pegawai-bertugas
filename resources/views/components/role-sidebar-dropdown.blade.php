<!-- resources/views/components/role-sidebar-dropdown.blade.php -->
@props(['active' => false, 'label', 'shortLabel' => null])

<div x-data="{ dropdownOpen: {{ $active ? 'true' : 'false' }} }" class="w-full">

    <button @click="dropdownOpen = !dropdownOpen"
        :class="open ? 'flex-row px-4 py-3 rounded-full w-full' : 'flex-col w-20 h-20 p-2 rounded-full justify-center text-center mx-auto'"
        class="relative overflow-hidden group flex items-center {{ $active ? 'bg-purple-900 text-white shadow-sm' : 'bg-white text-purple-800 hover:text-white hover:shadow-inner hover:shadow-black/90' }} transition-colors duration-300">


        <span class="absolute left-0 top-0 h-full w-0 bg-purple-800 transition-all duration-300 ease-out group-hover:w-full shadow-inner shadow-black/90"></span>

        <div class="relative z-10 flex items-center w-full" :class="!open && 'flex-col justify-center'">


            <div :class="open ? 'w-6 h-6' : 'w-8 h-8 mx-auto mb-1'" class="flex justify-center items-center transition-transform duration-200 group-hover:scale-110">
                {{ $icon }}
            </div>


            <span x-show="open" class="mx-3 font-medium text-sm whitespace-nowrap flex-1 text-left">{{ $label }}</span>
            <span x-show="!open" class="text-[10px] font-medium w-full block leading-tight">{!! $shortLabel ?? $label !!}</span>


            <svg x-show="open" :class="dropdownOpen ? 'rotate-180' : ''" class="w-4 h-4 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </div>
    </button>


    <div x-show="dropdownOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="mt-2 space-y-2" :class="open ? 'px-4' : 'px-1'">
        {{ $slot }}
    </div>
</div>
