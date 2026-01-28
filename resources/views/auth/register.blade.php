<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-purple-600 to-indigo-600 px-4">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8">

            <!-- Logo -->
            <div class="flex justify-center mb-4">
                <img
                    src="{{ asset('images/bubbleblizz-logo.png') }}"
                    alt="Bubble Blizz Logo"
                    class="h-20 w-20 object-contain"
                >
            </div>

            <!-- Title -->
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-1">
                Create Account
            </h2>

            <p class="text-center text-gray-500 mb-6">
                Join BubbleBlizz and find your beverage
            </p>

            <!-- Validation Errors -->
            <x-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Name
                    </label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        autofocus
                        placeholder="Your name"
                        class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                    >
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Email
                    </label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        placeholder="you@example.com"
                        class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                    >
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Password
                    </label>
                    <input
                        type="password"
                        name="password"
                        required
                        placeholder="••••••••"
                        class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                    >
                </div>

                <!-- Confirm Password -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Confirm Password
                    </label>
                    <input
                        type="password"
                        name="password_confirmation"
                        required
                        placeholder="••••••••"
                        class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                    >
                </div>

                <!-- Terms (Jetstream optional) -->
                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <div class="mb-6">
                        <label class="flex items-start">
                            <input
                                type="checkbox"
                                name="terms"
                                required
                                class="mt-1 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                            >
                            <span class="ml-2 text-sm text-gray-600">
                                I agree to the
                                <a target="_blank" href="{{ route('terms.show') }}" class="text-indigo-600 hover:underline">Terms of Service</a>
                                and
                                <a target="_blank" href="{{ route('policy.show') }}" class="text-indigo-600 hover:underline">Privacy Policy</a>.
                            </span>
                        </label>
                    </div>
                @endif

                <!-- Submit -->
                <button
                    type="submit"
                    class="w-full py-3 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition"
                >
                    Register
                </button>
            </form>

            <!-- Login link -->
            <p class="text-center text-sm text-gray-600 mt-6">
                Already have an account?
                <a href="{{ route('login') }}" class="text-indigo-600 font-medium hover:underline">
                    Login
                </a>
            </p>

        </div>
    </div>
</x-guest-layout>
