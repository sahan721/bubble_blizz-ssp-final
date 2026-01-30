<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-purple-600 to-indigo-600 px-4">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8">
            
            <!-- Logo -->
            <div class="flex justify-center mb-6">
                <img
                    src="{{ asset('images/bubbleblizz-logo.png') }}"
                    alt="Bubble Blizz Logo"
                    class="h-16 w-16 object-contain"
                >
            </div>

            <!-- Title -->
            <h2 class="text-2xl font-bold text-center text-gray-900 mb-2">
                {{ __('Two-Factor Authentication') }}
            </h2>

            <p class="text-center text-gray-600 mb-6">
                {{ __('Please enter the authentication code to continue.') }}
            </p>

            <!-- Validation Errors -->
            <x-validation-errors class="mb-4" />

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            @if (session('debug_2fa_code'))
                <div class="mb-4 p-3 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded">
                    <strong>Debug Code:</strong> {{ session('debug_2fa_code') }}
                    <br><small class="text-xs">Remove this in production</small>
                </div>
            @endif

            <!-- 2FA Form -->
            <form method="POST" action="{{ route('two-factor.verify') }}">
                @csrf

                <!-- Code Input -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Authentication Code') }}
                    </label>
                    <input
                        type="text"
                        name="code"
                        inputmode="numeric"
                        pattern="[0-9]*"
                        maxlength="6"
                        required
                        autofocus
                        placeholder="{{ $user->two_factor_type === 'email' ? 'Enter 6-digit code from email' : 'Enter 6-digit code from app' }}"
                        class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-center text-2xl tracking-widest"
                    >
                    <p class="mt-2 text-xs text-gray-500">
                        @if($user->two_factor_type === 'email')
                            {{ __('A 6-digit code has been sent to your email address.') }}
                        @else
                            {{ __('Enter the code from your authenticator app.') }}
                        @endif
                    </p>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="w-full py-3 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition mb-4"
                >
                    {{ __('Verify') }}
                </button>
            </form>

            <!-- Recovery Option -->
            <div class="text-center text-sm text-gray-600 mb-4">
                {{ __('Lost your device? ') }}
                <a href="#" class="text-indigo-600 hover:underline">
                    {{ __('Use a recovery code') }}
                </a>
            </div>

            <!-- Resend Code (Email only) -->
            @if($user->two_factor_type === 'email')
                <form method="POST" action="{{ route('two-factor.resend-email') }}" class="text-center">
                    @csrf
                    <button
                        type="submit"
                        class="text-sm text-indigo-600 hover:underline"
                    >
                        {{ __('Resend Code') }}
                    </button>
                </form>
            @endif

            <!-- Back to Login -->
            <div class="text-center mt-6">
                <a href="{{ route('logout') }}" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   class="text-sm text-gray-500 hover:text-gray-700">
                    {{ __('Back to Login') }}
                </a>
                
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>

        </div>
    </div>
</x-guest-layout>