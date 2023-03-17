<x-guest-layout>
    @section('title')
    IT System - Login
    @endsection
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <img src="{{ asset('storage\images\logo\logo.png') }}" class="block w-60 h-auto" alt="">
                {{-- <x-application-logo class="w-20 h-20 fill-current text-gray-200" /> --}}
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form id="loginForm" method="POST" action="{{ route('login') }}">
            @csrf

            <!-- ID Number -->
            <div>
                <x-input-label for="id_no" :value="__('ID Number')" />
                <div class="flex items-start">
                    <div class="self-center mt-1.5">
                        <h1 class="font-black text-xl text-gray-100 whitespace-nowrap leading-10 mr-1">HII</h1>
                    </div>
                    <i class="uil uil-minus self-center mt-1.5 text-xl text-gray-100 mr-1"></i>
                    <x-text-input id="id_no" autocomplete="off" class="hidden mt-1 w-full" type="text" name="id_no" :value="old('id_no')" required autofocus/>
                    <x-text-input id="id_no2" autocomplete="off" class="block mt-1 w-full" type="text" name="id_no2" :value="old('id_no2')" required autofocus/>
                </div>
                <x-input-error :messages="$errors->get('id_no')" class="mt-2"/>
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-primary-button id="submitButton" style="display: block !important;" class="w-full py-3 text-center">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>
    </x-auth-card>

    <script>
        $(document).ready(function() {
            $('#password').on('keydown', function(e) {
                if (e.keyCode === 13) {
                    var newID = 'HII-' + $('#id_no2').val();
                    $('#id_no').val(newID);
                    $('#loginForm').submit();
                }
            });
            $('#id_no2').on('keydown', function(e) {
                if (e.keyCode === 13) {
                    var newID = 'HII-' + $('#id_no2').val();
                    $('#id_no').val(newID);
                    $('#loginForm').submit();
                }
            });
            $('#submitButton').on('click', function() {
                var newID = 'HII-' + $('#id_no2').val();
                $('#id_no').val(newID);
                $('#loginForm').submit();
            });
        });
    </script>
</x-guest-layout>
