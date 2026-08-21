<x-slot name="header">
        <div class="flex items-center justify-end gap-4 w-full mt-4">

                <div class="p-2 bg-white shadow-md rounded-lg space-x-4 px-4">
                    {{ Auth::user()->name }} | <span>{{ str_replace('_', ' ', Auth::user()->role) }}</span>
                </div>
                <a href="{{ route('profile.edit') }}" tittle="log keluar"  class="p-2 text-purple-500 bg-white shadow-lg transition-colors rounded-lg hover:bg-purple-100 hover:text-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-900">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                </a>
                <a href="#" tittle="notification"  class="p-2 text-purple-500 bg-white shadow-lg transition-colors rounded-lg hover:bg-purple-100 hover:text-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-900">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                </a>

                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="py-2 px-4 text-purple-500 bg-white shadow-lg transition-colors rounded-lg hover:bg-purple-100 hover:text-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-900">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd" d="M7.5 3.75A1.5 1.5 0 0 0 6 5.25v13.5a1.5 1.5 0 0 0 1.5 1.5h6a1.5 1.5 0 0 0 1.5-1.5V15a.75.75 0 0 1 1.5 0v3.75a3 3 0 0 1-3 3h-6a3 3 0 0 1-3-3V5.25a3 3 0 0 1 3-3h6a3 3 0 0 1 3 3V9A.75.75 0 0 1 15 9V5.25a1.5 1.5 0 0 0-1.5-1.5h-6Zm5.03 4.72a.75.75 0 0 1 0 1.06l-1.72 1.72h10.94a.75.75 0 0 1 0 1.5H10.81l1.72 1.72a.75.75 0 1 1-1.06 1.06l-3-3a.75.75 0 0 1 0-1.06l3-3a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </form>

            </div>
    </x-slot>
