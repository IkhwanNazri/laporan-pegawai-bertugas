<!-- resources/views/components/sidebar-link.blade.php -->
@props(['href', 'active' => false, 'label', 'shortLabel' => null])

<a href="{{ $href }}"
   :class="open ? 'flex-row px-4 py-3 rounded-full' : 'flex-col w-20 h-20 p-2 rounded-full justify-center text-center'"
   class="relative overflow-hidden group flex items-center {{ $active ? 'bg-purple-900 text-white shadow-lg' : 'bg-white/40 text-purple-800 hover:text-white hover:shadow-inner hover:shadow-black/90' }} transition-colors duration-300">


    <span class="absolute left-0 top-0 h-full w-0 bg-purple-800 transition-all duration-300 ease-out group-hover:w-full shadow-inner shadow-black/90"></span>

    <div class="relative z-10 flex items-center w-full" :class="!open && 'flex-col justify-center'">


        <div :class="open ? 'w-6 h-6' : 'w-8 h-8 mx-auto mb-1'" class="flex justify-center items-center transition-transform duration-200 group-hover:scale-110">
            {{ $slot }}
        </div>


        <span x-show="open" class="mx-3 font-medium text-sm whitespace-nowrap">{{ $label }}</span>


        <span x-show="!open" class="text-[10px] font-medium w-full block leading-tight">{!! $shortLabel ?? $label !!}</span>

    </div>
</a>
