<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="" :status="session('status')" />


    <div x-data="{ view: 'login' }" class="w-full overflow-hidden pb-4">


        <div class="flex flex-col items-center justify-center w-full bg-white/80 p-4 rounded-t-lg mb-4">
            <img src="{{ asset('asset/logo.png') }}" alt="Logo Sistem" class="h-20 mb-2">
            <span class="text-center text-lg font-bold text-purple-900 leading-tight" style="font-family: 'Poppins', sans-serif; -webkit-text-stroke: 0.1px white;">
                Kementerian Perpaduan Negara
            </span>
            <span class="text-center text-lg text-purple-900 font-medium" style="font-family: 'Poppins', sans-serif;">
               Laporan Pegawai Bertugas
            </span>
        </div>


        <div class="flex justify-center rounded-full p-1 mx-6  relative z-20 shadow-inner shadow-black/40">

            <button type="button" @click="view = 'login'"
                :class="view === 'login' ? 'bg-purple-900 text-white shadow-lg shadow-black/20' : 'text-white hover:text-white/70'"
                class="w-1/2 py-2 rounded-full font-semibold text-md  tracking-wide transition-all duration-300" style="font-family: 'Montserrat', sans-serif;">
                Log Masuk
            </button>


            <button type="button" @click="view = 'register'"
                :class="view === 'register' ? 'bg-purple-900 text-white shadow-lg shadow-black/20' : 'text-white hover:text-white/70'"
                class="w-1/2 py-2 rounded-full font-semibold text-md  tracking-wide transition-all duration-300" style="font-family: 'Montserrat', sans-serif;">
                Daftar
            </button>
        </div>


        <div class="flex transition-transform duration-500 ease-in-out w-[200%]"
             :class="view === 'login' ? 'translate-x-0' : '-translate-x-1/2'">


            <div class="w-1/2">
                <form method="POST" action="{{ route('login') }}" class="w-full">
                    @csrf

                    <div class="p-2 px-6 mt-2">
                        <x-text-input id="no_ic_login" class="block mt-1 w-full text-white bg-white/10 border-none rounded-xl placeholder:text-white" type="text" name="no_ic" :value="old('no_ic')" maxlenght="12" required autofocus placeholder="No. Mykad" style="font-family: 'Montserrat', sans-serif;" />
                        <x-input-error :messages="$errors->get('no_ic')" class="mt-2 text-white" style="font-family: 'Montserrat', sans-serif;" />
                    </div>

                  <div class="p-2 px-6">
                    <div x-data="{ show: false }" class="relative mt-1">
                        <x-text-input id="password_login" class="block w-full text-white bg-white/10 border-none rounded-xl placeholder:text-white pr-10" x-bind:type="show ? 'text' : 'password'" name="password" required placeholder="Kata Laluan" style="font-family: 'Montserrat', sans-serif;" />

                        <button type="button" @click="show = !show" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-800">
                            <svg x-show="show" x-cloak class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            <svg x-show="!show" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.978 9.978 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                    <div class="flex justify-between p-2 px-6 mt-2">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-white text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                            <span class="ms-2 text-sm text-white" style="font-family: 'Montserrat', sans-serif;">{{ __('Ingat Saya') }}</span>
                        </label>
                         @if (Route::has('password.request'))
                            <a class="underline text-sm text-white hover:text-gray-900 rounded-md focus:outline-none transition" href="{{ route('password.request') }}" style="font-family: 'Montserrat', sans-serif;">
                                {{ __('Lupa Kata Laluan?') }}
                            </a>
                        @endif
                    </div>


                    <div class="mt-6 p-2 px-6">
                        <x-primary-button class="w-full justify-center rounded-full capitalize font-semibold py-3" style="font-family: 'Montserrat', sans-serif;">
                            {{ __('Log Masuk') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>


            <div class="w-1/2">
                <form method="POST" action="{{ route('register') }}" class="w-full">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-2 px-6 mt-2">


                        <div class="col-span-1 sm:col-span-2">
                            <x-text-input id="name" class="block w-full bg-transparent border-0 border-b-2 text-white border-white/50 rounded-none shadow-none focus:border-white focus:ring-0 px-2 placeholder:text-white" type="text" name="name" :value="old('name')" required placeholder="Nama Penuh" style="font-family: 'Montserrat', sans-serif;" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="col-span-1 sm:col-span-2">
                            <x-text-input id="no_ic_register" class="block w-full bg-transparent border-0 border-b-2 text-white border-white/50 rounded-none shadow-none focus:border-white focus:ring-0 px-2 placeholder:text-white" type="text" name="no_ic" :value="old('no_ic')" required placeholder="No. Mykad" style="font-family: 'Montserrat', sans-serif;" />
                            <x-input-error :messages="$errors->get('no_ic')" class="mt-2" />
                        </div>



                        <div>
                            <div x-data="{ show: false }" class="relative">

                                <x-text-input id="password_register"
                                    class="block w-full bg-transparent border-0 border-b-2 text-white border-white/50 rounded-none shadow-none focus:border-white focus:ring-0 pl-2 pr-10 placeholder:text-white"
                                    x-bind:type="show ? 'text' : 'password'"
                                    name="password"
                                    required
                                    placeholder="Kata Laluan"
                                    style="font-family: 'Montserrat', sans-serif;" />

                                <button type="button" @click="show = !show" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-white/70 hover:text-white focus:outline-none">
                                    <svg x-show="show" x-cloak class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg x-show="!show" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.978 9.978 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>


                        <div>
                            <div x-data="{ show: false }" class="relative">

                                <x-text-input id="password_confirmation"
                                    class="block w-full bg-transparent border-0 border-b-2 text-white border-white/50 rounded-none shadow-none focus:border-white focus:ring-0 pl-2 pr-10 placeholder:text-white"
                                    x-bind:type="show ? 'text' : 'password'"
                                    name="password_confirmation"
                                    required
                                    placeholder="Sahkan Kata"
                                    style="font-family: 'Montserrat', sans-serif;" />

                                <button type="button" @click="show = !show" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-white/70 hover:text-white focus:outline-none">
                                    <svg x-show="show" x-cloak class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg x-show="!show" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.978 9.978 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>
                    </div>
                    <div class="px-6">
                        <a class="underline text-sm text-white hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>
                    </div>

                    <div class=" mt-4 px-6">
                        <x-primary-button class="w-full justify-center rounded-full py-3 capitalize font-semibold" style="font-family: 'Montserrat', sans-serif;">
                            {{ __('Daftar') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-guest-layout>
