<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-white">Buat Akun</h2>
        <p class="text-sm text-gray-400 mt-2">Bergabung dengan komunitas akademik</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" value="Nama Lengkap" class="mb-1 text-gray-300" />
            <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="Alamat Email" class="mb-1 text-gray-300" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="you@institution.edu" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" value="Kata Sandi" class="mb-1 text-gray-300" />
            <x-text-input id="password" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" value="Konfirmasi Kata Sandi" class="mb-1 text-gray-300" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-4">
            <x-primary-button class="w-full justify-center py-3 text-base shadow-lg shadow-purple-900/20">
                {{ __('Daftar Akun') }}
            </x-primary-button>
        </div>

        <div class="text-center pt-2">
            <span class="text-sm text-gray-500">Sudah punya akun? </span>
            <a href="{{ route('login') }}" class="text-sm font-medium text-cyan-400 hover:text-cyan-300 hover:underline transition-colors">{{ __('Masuk') }}</a>
        </div>
    </form>
</x-guest-layout>
