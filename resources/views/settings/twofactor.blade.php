<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Two-Factor Authentication') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:p-10">
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900">
                            {{ __('Two-Factor Authentication') }}
                        </h3>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('Add extra security to your account using two-factor authentication.') }}
                        </p>
                    </div>

                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if($user->two_factor_enabled)
                        <div class="mb-6 p-4 bg-green-50 rounded-lg">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-green-800">
                                        {{ __('Two-factor authentication is enabled.') }}
                                    </h3>
                                    <div class="mt-2 text-sm text-green-700">
                                        <p>
                                            {{ __('Your account is secured with two-factor authentication using ') }}
                                            <strong>{{ ucfirst($user->two_factor_type) }}</strong>
                                            {{ __(' method.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @if($user->two_factor_type === 'totp')
                                <div class="bg-gray-50 p-6 rounded-lg">
                                    <h4 class="text-lg font-medium text-gray-900 mb-4">
                                        {{ __('Recovery Codes') }}
                                    </h4>
                                    <p class="text-sm text-gray-600 mb-4">
                                        {{ __('Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two-factor authentication device is lost.') }}
                                    </p>
                                    <a href="{{ route('two-factor.recovery-codes') }}" 
                                       class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                                        {{ __('View Recovery Codes') }}
                                    </a>
                                </div>
                            @endif

                            <div class="bg-gray-50 p-6 rounded-lg">
                                <h4 class="text-lg font-medium text-gray-900 mb-4">
                                    {{ __('Disable Two-Factor Authentication') }}
                                </h4>
                                <p class="text-sm text-gray-600 mb-4">
                                    {{ __('Disabling two-factor authentication will reduce the security of your account.') }}
                                </p>
                                <form method="POST" action="{{ route('two-factor.disable') }}">
                                    @csrf
                                    <button type="submit" 
                                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring focus:ring-red-300 disabled:opacity-25 transition"
                                            onclick="return confirm('Are you sure you want to disable two-factor authentication?')">
                                        {{ __('Disable') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="mb-6 p-4 bg-yellow-50 rounded-lg">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-yellow-800">
                                        {{ __('Two-factor authentication is not enabled.') }}
                                    </h3>
                                    <div class="mt-2 text-sm text-yellow-700">
                                        <p>
                                            {{ __('When two-factor authentication is enabled, you will be prompted for a secure, random token during authentication. This token is generated by an application on your phone.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-gray-50 p-6 rounded-lg">
                                <h4 class="text-lg font-medium text-gray-900 mb-4">
                                    {{ __('Authenticator App') }}
                                </h4>
                                <p class="text-sm text-gray-600 mb-4">
                                    {{ __('Use an authenticator app like Google Authenticator, Microsoft Authenticator, or Authy to scan the QR code.') }}
                                </p>
                                <form method="POST" action="{{ route('two-factor.enable') }}">
                                    @csrf
                                    <input type="hidden" name="type" value="totp">
                                    <button type="submit" 
                                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                                        {{ __('Enable Authenticator App') }}
                                    </button>
                                </form>
                            </div>

                            <div class="bg-gray-50 p-6 rounded-lg">
                                <h4 class="text-lg font-medium text-gray-900 mb-4">
                                    {{ __('Email Code') }}
                                </h4>
                                <p class="text-sm text-gray-600 mb-4">
                                    {{ __('Receive a 6-digit code via email each time you log in.') }}
                                </p>
                                <form method="POST" action="{{ route('two-factor.enable') }}">
                                    @csrf
                                    <input type="hidden" name="type" value="email">
                                    <button type="submit" 
                                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                                        {{ __('Enable Email Code') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>