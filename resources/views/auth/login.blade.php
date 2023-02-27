<x-guest-layout>
    @section('title')
    IT System - Login
    @endsection
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <img src="{{ asset('storage\images\logo\logo.png') }}" class="block w-20 h-auto" alt="">
                {{-- <x-application-logo class="w-20 h-20 fill-current text-gray-200" /> --}}
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- ID Number -->
            <div>
                <x-input-label for="id_no" :value="__('ID Number')" />
                <x-text-input id="id_no" autocomplete="off" class="block mt-1 w-full" type="text" name="id_no" :value="old('id_no')" required autofocus/>
                <x-input-error :messages="$errors->get('id_no')" class="mt-2"/>
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-primary-button style="display: block !important;" class="w-full py-3 text-center">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
