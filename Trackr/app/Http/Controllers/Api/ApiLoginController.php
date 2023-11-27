<?php

namespace App\Http\Controllers\Api;

use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class ApiLoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $user = Auth::user();
            $token = $user->createToken('token-name')->plainTextToken;

            // Handmatig PersonalAccessToken-object maken en instellen op huidige gebruiker
            $personalAccessToken = new PersonalAccessToken;
            $personalAccessToken->forceFill([
                'token' => hash('sha256', $token),
                'name' => 'token-name',
                'abilities' => ['*'],
                'tokenable_type' => User::class,
                'tokenable_id' => $user->id,
            ]);

            // Vervaltijd van token instellen
            $personalAccessToken->expires_at = now()->addHours(24);
            $personalAccessToken->save();

            return response()->json([
                'user' => $user,
                'token' => $token,
            ]);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out']);
    }
}

