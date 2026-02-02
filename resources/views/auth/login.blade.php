<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-md bg-white/10 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/20 p-8">
            
            <!-- Logo -->
            <div class="flex justify-center mb-6">
                <img
                    src="{{ asset('images/bubbleblizz-logo.png') }}"
                    alt="Bubble Blizz Logo"
                    class="h-20 w-20 object-contain drop-shadow-lg"
                >
            </div>
            
            <!-- Title -->
            <h2 class="text-3xl font-bold text-center text-white mb-2 drop-shadow">
                Welcome Back
            </h2>
            
            <p class="text-center text-white/80 mb-8 drop-shadow">
                Login to your BubbleBlizz account
            </p>
            
            <!-- Validation Errors -->
            <x-validation-errors class="mb-6 text-white" />
            
            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <!-- ✅ Role -->
                <div class="mb-5">
                    <label class="block text-sm font-medium text-white/90 mb-2 drop-shadow">
                        Role
                    </label>
                    <select
                        name="role"
                        id="role-select"
                        required
                        class="w-full rounded-lg bg-white/20 border border-white/30 text-white placeholder-white/70 focus:border-white/50 focus:ring-white/30 backdrop-blur-sm"
                    >
                        <option value="customer" {{ old('role', 'customer') === 'customer' ? 'selected' : '' }} class="bg-gray-800">
                            Customer
                        </option>
                        <option value="rider" {{ old('role') === 'rider' ? 'selected' : '' }} class="bg-gray-800">
                            Rider
                        </option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }} class="bg-gray-800">
                            Admin
                        </option>
                    </select>
                    
                    <p class="mt-2 text-xs text-white/70 drop-shadow">
                        Select your role before logging in.
                    </p>
                </div>
                
                <!-- Email -->
                <div class="mb-5">
                    <label class="block text-sm font-medium text-white/90 mb-2 drop-shadow">
                        Email
                    </label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        placeholder="you@example.com"
                        class="w-full rounded-lg bg-white/20 border border-white/30 text-white placeholder-white/70 focus:border-white/50 focus:ring-white/30 backdrop-blur-sm"
                    >
                </div>
                
                <!-- Password -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-white/90 mb-2 drop-shadow">
                        Password
                    </label>
                    <input
                        type="password"
                        name="password"
                        required
                        placeholder="••••••••"
                        class="w-full rounded-lg bg-white/20 border border-white/30 text-white placeholder-white/70 focus:border-white/50 focus:ring-white/30 backdrop-blur-sm"
                    >
                </div>
                
                <!-- Remember + Forgot -->
                <div class="flex items-center justify-between mb-8">
                    <label class="flex items-center text-sm text-white/80 drop-shadow">
                        <input
                            type="checkbox"
                            name="remember"
                            class="rounded border-white/30 bg-white/20 text-indigo-400 focus:ring-indigo-300/50"
                        >
                        <span class="ml-2">Remember me</span>
                    </label>
                    
                    @if (Route::has('password.request'))
                        <a
                            href="{{ route('password.request') }}"
                            class="text-sm text-indigo-200 hover:text-white drop-shadow hover:underline"
                        >
                            Forgot password?
                        </a>
                    @endif
                </div>
                
                <!-- Submit -->
                <button
                    type="submit"
                    class="w-full py-3.5 rounded-xl bg-white/20 hover:bg-white/30 border border-white/30 text-white font-semibold backdrop-blur-sm transition-all duration-200 hover:scale-[1.02] hover:shadow-lg"
                >
                    Login
                </button>
            </form>
            
            <!-- Divider -->
            <div class="relative my-8">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-white/30"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-3 bg-white/10 backdrop-blur-sm text-white/80 drop-shadow">Or continue with</span>
                </div>
            </div>
            
            <!-- Google Login Button (Visible only for Customer role) -->
            @if(old('role', 'customer') === 'customer')
            <div class="mb-6">
                <a
                    href="{{ route('auth.google') }}"
                    id="google-login-btn"
                    class="w-full flex items-center justify-center gap-3 py-3.5 px-4 rounded-xl border border-white/30 bg-white/10 hover:bg-white/20 text-white font-medium backdrop-blur-sm transition-all duration-200 hover:scale-[1.02]"
                >
                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                        <path fill="#FFFFFF" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#FFFFFF" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FFFFFF" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="#FFFFFF" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    Continue with Google
                </a>
            </div>
            @endif
            
            <!-- JavaScript to toggle Google login button based on selected role -->
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const roleSelect = document.getElementById('role-select');
                    const googleLoginBtn = document.getElementById('google-login-btn');
                    
                    if (roleSelect && googleLoginBtn) {
                        const googleLoginContainer = googleLoginBtn.closest('.mb-6');
                        
                        function toggleGoogleLogin() {
                            if (roleSelect.value === 'customer') {
                                googleLoginContainer.style.display = 'block';
                            } else {
                                googleLoginContainer.style.display = 'none';
                            }
                        }
                        
                        // Initial check
                        toggleGoogleLogin();
                        
                        // Add event listener for role changes
                        roleSelect.addEventListener('change', toggleGoogleLogin);
                    }
                });
            </script>
        </div>
    </div>
</x-guest-layout>