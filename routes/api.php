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

    /*
    |--------------------------------------------------------------------------
    | ADMIN ONLY APIs (protected by role check)
    |--------------------------------------------------------------------------
    */
    Route::middleware('api.admin')->group(function () {
        
        // Admin Orders
        Route::get('/admin/orders', function (Request $request) {
            $status = $request->query('status');
            
            $ordersQuery = \App\Models\Order::with(['user', 'rider']);
            
            // Filter by status
            if (!empty($status)) {
                $ordersQuery->where('status', $status);
            }
            
            // Sort by status priority then by created_at
            $ordersQuery->orderByRaw("CASE
                WHEN status = 'Pending' THEN 0
                WHEN status = 'Assigned' THEN 1
                WHEN status = 'Picked Up' THEN 2
                WHEN status = 'Delivered' THEN 3
                WHEN status = 'Cancelled' THEN 4
                ELSE 5
            END")
            ->latest('created_at');
            
            $orders = $ordersQuery->paginate(10);
            
            return response()->json($orders);
        });
        
        // Get single order details
        Route::get('/admin/orders/{order}', function (\App\Models\Order $order) {
            $order->load(['user', 'rider', 'items.product']);
            return response()->json($order);
        });
        
        // Update order status and rider
        Route::put('/admin/orders/{order}', function (Request $request, \App\Models\Order $order) {
            $validated = $request->validate([
                'status' => 'required|in:Pending,Assigned,Picked Up,Delivered,Cancelled',
                'rider_id' => 'nullable|exists:users,id',
            ]);
            
            // Check if rider exists and is actually a rider
            if ($validated['rider_id']) {
                $rider = \App\Models\User::where('id', $validated['rider_id'])
                    ->whereRaw("LOWER(role) = 'rider'")
                    ->first();
                
                if (!$rider) {
                    return response()->json(['message' => 'Selected user is not a rider'], 400);
                }
            }
            
            // Update the order
            $order->status = $validated['status'];
            $order->rider_id = $validated['rider_id'] ?? null;
            
            // Set assigned_at timestamp if assigning a rider
            if ($validated['rider_id'] && !$order->assigned_at) {
                $order->assigned_at = now();
            }
            
            $order->save();
            
            return response()->json(['message' => 'Order updated successfully', 'order' => $order]);
        });
        
        // Assign rider to order
        Route::post('/admin/orders/{order}/assign', function (Request $request, \App\Models\Order $order) {
            // Lock completed/cancelled orders
            if (in_array($order->status, ['Delivered', 'Cancelled'], true)) {
                return response()->json(['message' => 'This order is locked and cannot be reassigned'], 400);
            }
            
            $validated = $request->validate([
                'rider_id' => 'required|exists:users,id',
            ]);
            
            // Ensure selected user is actually a rider
            $rider = \App\Models\User::where('id', $validated['rider_id'])
                ->whereRaw("LOWER(role) = 'rider'")
                ->first();
            
            if (!$rider) {
                return response()->json(['message' => 'Selected user is not a rider'], 400);
            }
            
            // Assign and update workflow fields
            $order->rider_id = $rider->id;
            
            // If order was Pending, move it to Assigned
            if ($order->status === 'Pending') {
                $order->status = 'Assigned';
            }
            
            // Always set assigned_at when assigning
            $order->assigned_at = now();
            
            $order->save();
            
            return response()->json(['message' => 'Rider assigned successfully', 'order' => $order]);
        });
        
        // Get available riders
        Route::get('/admin/riders', function () {
            $riders = \App\Models\User::select('id', 'name', 'email')
                ->whereRaw("LOWER(role) = 'rider'")
                ->orderBy('name')
                ->get();
            
            return response()->json($riders);
        });
        
        // Get order statuses
        Route::get('/admin/order-statuses', function () {
            $statuses = ['Pending', 'Assigned', 'Picked Up', 'Delivered', 'Cancelled'];
            return response()->json($statuses);
        });
    });
});
