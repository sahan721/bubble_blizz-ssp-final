<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bubble Blizz</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-cover bg-center bg-no-repeat bg-fixed" 
      style="background-image: url('/images/banner.png');">
    
    <!-- Professional layered overlay -->
    <div class="min-h-screen bg-gradient-to-br from-black/70 via-indigo-900/60 to-blue-900/70 backdrop-blur-sm">
        
        <main class="relative min-h-screen flex items-center justify-center px-6 py-12">
            <div class="w-full max-w-md">
                
                <!-- Glassmorphism Card -->
                <div class="rounded-3xl bg-white/10 backdrop-blur-xl border border-white/20 shadow-2xl p-8 sm:p-10 text-center">
                    
                    <!-- Tagline -->
                    <p class="text-xs font-semibold tracking-[0.25em] text-white/80 uppercase drop-shadow">
                        Find your beverage
                    </p>
                    
                    <!-- Brand -->
                    <h1 class="mt-3 text-4xl sm:text-5xl font-extrabold tracking-tight text-white drop-shadow">
                        Bubble<span class="text-indigo-300">Blizz</span>
                    </h1>
                    
                    <!-- Sub text -->
                    <p class="mt-3 text-sm text-white/80 drop-shadow">
                        Order your favourite drinks fast — fresh, chilled, and delivered.
                    </p>
                    
                    <!-- Logo -->
                    <div class="mt-7 flex justify-center">
                        <div class="rounded-2xl bg-white/10 backdrop-blur border border-white/20 p-4 shadow-lg">
                            <img
                                src="{{ asset('images/bubbleblizz-logo.png') }}"
                                alt="Bubble Blizz Logo"
                                class="h-36 w-36 object-contain drop-shadow-lg"
                            >
                        </div>
                    </div>
                    
                    <!-- Actions -->
                    <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center justify-center rounded-xl bg-white/20 hover:bg-white/30 border border-white/30 px-6 py-3.5 text-sm font-semibold text-white backdrop-blur-sm shadow hover:scale-[1.02] transition-all duration-200">
                            Login
                        </a>
                        
                        <a href="{{ route('register') }}"
                           class="inline-flex items-center justify-center rounded-xl bg-white/20 hover:bg-white/30 border border-white/30 px-6 py-3.5 text-sm font-semibold text-white backdrop-blur-sm shadow hover:scale-[1.02] transition-all duration-200">
                            Register
                        </a>
                    </div>
                    
                    <!-- Footer note -->
                    <p class="mt-6 text-xs text-white/70 drop-shadow">
                        BubbleBlizz © {{ date('Y') }} • Secure login via Jetstream
                    </p>
                </div>
                
            </div>
        </main>
    </div>
</body>
</html>