<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-lg">
            <!-- Logo HKBP -->
            <div class="text-center mb-6">
                <img src="{{ asset('images/logo-hkbp.png') }}" alt="HKBP Logo" class="mx-auto h-20">
                <h2 class="text-2xl font-semibold text-green-600 mt-4">Login E-Inventory</h2>
                <p class="text-sm text-gray-600">HKBP Setia Mekar</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-4">
                    <x-input-label for="email" :value="__('Email')" class="text-sm font-medium text-gray-700" />
                    <div class="mt-1">
                        <x-text-input id="email" 
                            class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" 
                            type="email" 
                            name="email" 
                            :value="old('email')" 
                            required 
                            autofocus 
                            autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-1 text-sm text-red-600" />
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <x-input-label for="password" :value="__('Password')" class="text-sm font-medium text-gray-700" />
                    <div class="mt-1 relative">
                        <x-text-input id="password" 
                            class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" 
                            type="password"
                            name="password"
                            required 
                            autocomplete="current-password" />
                        <button type="button" 
                            onclick="togglePassword('password', 'toggleIcon')"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                        <x-input-error :messages="$errors->get('password')" class="mt-1 text-sm text-red-600" />
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center mb-6">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" 
                            type="checkbox" 
                            class="rounded border-gray-300 text-green-600 focus:ring-green-500" 
                            name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Ingat Saya') }}</span>
                    </label>
                </div>

                <button type="submit" 
                    class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors">
                    {{ __('Login') }}
                </button>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
    </script>
    @endpush
</x-guest-layout>
