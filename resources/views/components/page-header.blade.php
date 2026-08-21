<!-- resources/views/components/page-header.blade.php -->
@props(['title', 'breadcrumbs' => []])

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center w-full mb-6">
    
    <!-- Tajuk Muka Surat (Kiri) -->
    <h2 class="text-2xl font-bold text-gray-800 tracking-tight">
        {{ $title }}
    </h2>

    <!-- Breadcrumbs (Kanan) -->
    <div class="mt-4 sm:mt-0">
        <x-breadcrumb :items="$breadcrumbs" />
    </div>

</div>