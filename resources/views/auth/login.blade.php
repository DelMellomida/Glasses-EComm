<x-nav-guest></x-nav-guest>
<x-guest-layout >
    <div class="bg-[url('../build/assets/images/LoginWallpaper.jpg')] bg-cover bg-center">
    <x-authentication-card>
        <x-slot name="logo">
            <img src="{{ asset('build/assets/Images/Sarabia-logo-white.png') }}" class="h-12" alt="Sarabia Logo" />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="grid grid-rows-2 gap-6 p-5">
                <div>
                    <x-label for="email" value="{{ __('') }}" />
                    <input id="email" class="w-full rounded-lg border-5 backdrop-blur-md bg-transparent" type="email" name="email" :value="old('email')" placeholder="Email" required autofocus autocomplete="username" />
                </div>

                <div>
                    <x-label for="password" value="{{ __('') }}" />
                    <input id="password" class="w-full rounded-lg border-5 bg-transparent" type="password" name="password" placeholder="Password" required autocomplete="current-password" />
                </div>

            </div>
            <div class="grid grid-cols-2 gap-5 pl-5">
                <div class="">
                    <label for="remember_me" class="flex items-center">
                        <x-checkbox id="remember_me" name="remember" />
                        <span class="ms-2 text-sm text-white">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="pl-5">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-white hover:text-white-500 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                </div>
            </div>

            <div class="grid grid-rows-2 gap-3 justify-center">

                <x-button class="mt-5 text-center">
                    {{ __('Log in') }}
                </x-button>


                <div class="">
                    <span class="text-white ms-2 text-sm">Not a member?</span> <a href="{{ route('register') }}" class="text-white ms-2 text-sm underline">Register here!</a>
                </div>
            </div>
        </form>
    </x-authentication-card>
    </div>
</x-guest-layout>

