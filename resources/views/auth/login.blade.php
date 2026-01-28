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
                Welcome Back
            </h2>

            <p class="text-center text-gray-500 mb-6">
                Login to your BubbleBlizz account
            </p>

            <!-- Validation Errors -->
            <x-validation-errors class="mb-4" />

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- ✅ Role -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Role
                    </label>
                    <select
                        name="role"
                        required
                        class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                    >
                        <option value="customer" {{ old('role', 'customer') === 'customer' ? 'selected' : '' }}>
                            Customer
                        </option>
                        <option value="rider" {{ old('role') === 'rider' ? 'selected' : '' }}>
                            Rider
                        </option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>
                            Admin
                        </option>
                    </select>

                    <p class="mt-1 text-xs text-gray-500">
                        Select your role before logging in.
                    </p>
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
                        autofocus
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

                <!-- Remember + Forgot -->
                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center text-sm text-gray-600">
                        <input
                            type="checkbox"
                            name="remember"
                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                        >
                        <span class="ml-2">Remember me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a
                            href="{{ route('password.request') }}"
                            class="text-sm text-indigo-600 hover:underline"
                        >
                            Forgot password?
                        </a>
                    @endif
                </div>

                <!-- Submit -->
                <button
                    type="submit"
                    class="w-full py-3 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition"
                >
                    Login
                </button>
            </form>

            <!-- Register -->
            <p class="text-center text-sm text-gray-600 mt-6">
                Don’t have an account?
                <a href="{{ route('register') }}" class="text-indigo-600 font-medium hover:underline">
                    Register
                </a>
            </p>

        </div>
    </div>
</x-guest-layout>

<!--
    Admin : admin@bubbleblizz.com / 12345678
    Rider : rider@bubbleblizz.com / 12345678
    Customer : customer@bubbleblizz.com / 12345678
-->
