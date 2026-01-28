<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Fortify\CreateNewUser;

class AuthController extends Controller
{
    public function register(Request $request, CreateNewUser $creator)
    {
        // Validation + creation done by Jetstream/Fortify action
        $user = $creator->create($request->all());

        $deviceName = $request->input('device', 'mobile');

        $token = $user->createToken($deviceName)->plainTextToken;

        return response()->json([
            'token'      => $token,
            'token_type' => 'Bearer',
            'role'       => $user->role ?? null,
            'name'       => $user->name,
            'email'      => $user->email,
        ], 201);
    }
}
