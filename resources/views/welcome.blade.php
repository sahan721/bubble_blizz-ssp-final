<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bubble Blizz</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50">
    <!-- subtle background -->
    <div class="pointer-events-none fixed inset-0">
        <div class="absolute -top-32 left-1/2 h-96 w-96 -translate-x-1/2 rounded-full bg-indigo-200/40 blur-3xl"></div>
        <div class="absolute -bottom-32 right-10 h-96 w-96 rounded-full bg-pink-200/40 blur-3xl"></div>
    </div>

    <main class="relative min-h-screen flex items-center justify-center px-6 py-12">
        <div class="w-full max-w-md">
            <!-- Card -->
            <div class="rounded-3xl bg-white/90 backdrop-blur border border-slate-200 shadow-xl p-8 sm:p-10 text-center">
                <!-- Tagline -->
                <p class="text-xs font-semibold tracking-[0.25em] text-slate-500 uppercase">
                    Find your beverage
                </p>

                <!-- Brand -->
                <h1 class="mt-3 text-4xl sm:text-5xl font-extrabold tracking-tight text-slate-900">
                    Bubble<span class="text-indigo-600">Blizz</span>
                </h1>

                <!-- Sub text -->
                <p class="mt-3 text-sm text-slate-600">
                    Order your favourite drinks fast — fresh, chilled, and delivered.
                </p>

                <!-- Logo -->
                <div class="mt-7 flex justify-center">
                    <div class="rounded-2xl bg-slate-50 border border-slate-200 p-4 shadow-sm">
                        <img
                            src="{{ asset('images/bubbleblizz-logo.png') }}"
                            alt="Bubble Blizz Logo"
                            class="h-36 w-36 object-contain"
                        >
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-6 py-3 text-sm font-semibold text-white shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                        Login
                    </a>

                    <a href="{{ route('register') }}"
                       class="inline-flex items-center justify-center rounded-xl bg-white px-6 py-3 text-sm font-semibold text-indigo-700 border border-indigo-200 shadow-sm hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                        Register
                    </a>
                </div>

                <!-- Footer note -->
                <p class="mt-6 text-xs text-slate-500">
                    BubbleBlizz © {{ date('Y') }} • Secure login via Jetstream
                </p>
            </div>
        </div>
    </main>
</body>
</html>
