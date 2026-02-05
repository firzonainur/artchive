<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-white">Selamat Datang Kembali</h2>
        <p class="text-sm text-gray-400 mt-2">Masuk ke akun Anda</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="Alamat Email" class="mb-1 text-gray-300" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" value="Kata Sandi" class="mb-1 text-gray-300" />
            <x-text-input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" class="rounded bg-gray-800 border-gray-600 text-purple-600 shadow-sm focus:ring-purple-500 focus:ring-offset-gray-900" name="remember">
                <span class="ms-2 text-sm text-gray-400 group-hover:text-gray-300 transition-colors">{{ __('Ingat saya') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-purple-400 hover:text-purple-300 hover:underline transition-colors" href="{{ route('password.request') }}">
                    {{ __('Lupa kata sandi?') }}
                </a>
            @endif
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full justify-center py-3 text-base shadow-lg shadow-purple-900/20">
                {{ __('Masuk') }}
            </x-primary-button>
        </div>
        
        <div class="text-center pt-2">
            <span class="text-sm text-gray-500">Baru di sini? </span>
            <a href="{{ route('register') }}" class="text-sm font-medium text-cyan-400 hover:text-cyan-300 hover:underline transition-colors">Buat akun</a>
        </div>
    </form>
</x-guest-layout>
