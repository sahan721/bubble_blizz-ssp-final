<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Models\Product;
use App\Models\Favorite;
use App\Http\Controllers\Api\AuthController;

Route::get('/ping', function () {
    return response()->json(['ok' => true]);
});

/*
|--------------------------------------------------------------------------
| Register (Sanctum)
| POST /api/register
| Body depends on Jetstream/Fortify CreateNewUser rules
|--------------------------------------------------------------------------
*/
Route::post('/register', [AuthController::class, 'register']);

/*
|--------------------------------------------------------------------------
| Token (Sanctum)
| POST /api/token
| Body: { "email": "...", "password": "...", "device": "pc" }
|--------------------------------------------------------------------------
*/
Route::post('/token', function (Request $request) {

    $request->validate([
        'email'    => ['required', 'email'],
        'password' => ['required', 'string'],
        'device'   => ['nullable', 'string'],
    ]);

    if (!Auth::attempt($request->only('email', 'password'))) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    $user = Auth::user();
    if (!$user) {
        return response()->json(['message' => 'Auth failed'], 401);
    }

    $deviceName = $request->input('device', 'mobile');

    // (Optional) if you want "one device = one token", uncomment this:
    // $user->tokens()->where('name', $deviceName)->delete();

    $token = $user->createToken($deviceName)->plainTextToken;

    return response()->json([
        'token'      => $token,
        'token_type' => 'Bearer',
        'role'       => $user->role ?? null,
        'name'       => $user->name,
        'email'      => $user->email,
    ]);
});

Route::middleware('auth:sanctum')->group(function () {

    // Logged in user info
    Route::get('/me', function (Request $request) {
        $user = $request->user();

        return response()->json([
            'id'    => $user->id,
            'name'  => $user->name,
            'email' => $user->email,
            'role'  => $user->role ?? null,
        ]);
    });

    /*
    |--------------------------------------------------------------------------
    | CUSTOMER ONLY APIs (protected by middleware alias)
    |--------------------------------------------------------------------------
    */
    Route::middleware('api.customer')->group(function () {

        // Products
        Route::get('/customer/products', function (Request $request) {
            $query = Product::query()->latest();

            if ($request->filled('category')) {
                $query->where('category', $request->string('category')->toString());
            }

            return response()->json($query->get());
        });

        // Favorites list
        Route::get('/customer/favorites', function (Request $request) {
            return response()->json(
                Favorite::with('product')
                    ->where('user_id', $request->user()->id)
                    ->latest()
                    ->get()
            );
        });

        // Toggle favorite
        Route::post('/customer/favorites/toggle', function (Request $request) {

            $request->validate([
                'product_id' => ['required', 'integer', 'exists:products,id'],
            ]);

            $userId = $request->user()->id;

            $fav = Favorite::query()
                ->where('user_id', $userId)
                ->where('product_id', $request->product_id)
                ->first();

            if ($fav) {
                $fav->delete();
                return response()->json(['favorited' => false]);
            }

            Favorite::create([
                'user_id'    => $userId,
                'product_id' => $request->product_id,
            ]);

            return response()->json(['favorited' => true]);
        });
    });

    // Logout current token
    Route::post('/logout', function (Request $request) {
        optional($request->user()->currentAccessToken())->delete();
        return response()->json(['message' => 'Logged out']);
    });

    // Logout all tokens
    Route::post('/logout-all', function (Request $request) {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out from all devices']);
    });
});
