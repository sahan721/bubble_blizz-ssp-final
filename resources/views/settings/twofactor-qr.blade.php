<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Setup Authenticator App') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:p-10">
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900">
                            {{ __('Scan the QR Code') }}
                        </h3>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('Scan the following QR code using your authenticator application.') }}
                        </p>
                    </div>

                    <div class="flex flex-col items-center mb-8">
                        <div class="p-6 bg-gray-50 rounded-xl mb-6">
                            @php
                                use BaconQrCode\Renderer\ImageRenderer;
                                use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
                                use BaconQrCode\Renderer\RendererStyle\RendererStyle;
                                use BaconQrCode\Writer;
                                
                                $renderer = new ImageRenderer(
                                    new RendererStyle(250),
                                    new ImagickImageBackEnd()
                                );
                                $writer = new Writer($renderer);
                                $qrCode = base64_encode($writer->writeString($qrCodeUrl));
                            @endphp
                            <img src="data:image/png;base64,{{ $qrCode }}" alt="QR Code">
                        </div>
                        
                        <p class="text-sm text-gray-600 mb-2">
                            {{ __('Or enter this code manually:') }}
                        </p>
                        <code class="px-4 py-2 bg-gray-100 rounded text-sm font-mono">
                            {{ decrypt($user->two_factor_secret) }}
                        </code>
                    </div>

                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    {{ __('Use an authenticator app like Google Authenticator, Microsoft Authenticator, or Authy to scan this QR code.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h4 class="text-md font-medium text-gray-900 mb-4">
                            {{ __('Enter the Code') }}
                        </h4>
                        <form method="POST" action="{{ route('two-factor.confirm-totp') }}">
                            @csrf
                            <div class="flex items-center space-x-4">
                                <input
                                    type="text"
                                    name="code"
                                    inputmode="numeric"
                                    pattern="[0-9]*"
                                    maxlength="6"
                                    required
                                    placeholder="{{ __('6-digit code') }}"
                                    class="flex-1 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-center text-2xl tracking-widest"
                                >
                                <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring focus:ring-indigo-300 disabled:opacity-25 transition">
                                    {{ __('Confirm') }}
                                </button>
                            </div>
                        </form>
                    </div>

                    <a href="{{ route('two-factor.settings') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                        {{ __('Back to Settings') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>