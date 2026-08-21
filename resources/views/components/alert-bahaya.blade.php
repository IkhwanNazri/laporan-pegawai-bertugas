 @if ($errors->any())
    <div class="p-4 mb-4 bg-red-100 border border-red-400 text-red-700 rounded-xl">
        <strong class="font-bold">Alamak! Ada masalah input:</strong>
        <ul class="mt-2 list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
