<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 flex items-center justify-center">

    <div class="bg-white rounded-2xl shadow-lg p-10 w-full max-w-md text-center">
        <h1 class="text-3xl font-extrabold text-slate-900">
            Admin Dashboard
        </h1>

        <p class="mt-3 text-slate-500">
            Dummy admin panel (temporary)
        </p>

        <div class="mt-8">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button
                    type="submit"
                    class="w-full rounded-xl bg-red-600 px-6 py-3
                           text-white font-semibold hover:bg-red-700 transition"
                >
                    Logout
                </button>
            </form>
        </div>
    </div>

</body>
</html>
