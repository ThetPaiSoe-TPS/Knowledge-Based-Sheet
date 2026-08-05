<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // ✅ Register with optional remember_token
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'sometimes|in:admin,editor,user'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? 'user'
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'User registered!',
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ], 201);
    }

    // ✅ Login with Remember Me
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'remember' => 'sometimes|boolean'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        // ✅ Set token expiration based on remember
        $remember = $request->remember ?? false;
        $expiration = $remember ? 525600 : 120; // 1 year or 2 hours

        $token = $user->createToken(
            'auth_token',
            ['*'],
            now()->addMinutes($expiration)
        )->plainTextToken;

        // ✅ Store remember token if needed
        if ($remember) {
            $user->remember_token = hash('sha256', $token);
            $user->save();
        }

        // ✅ Store remember flag in response
        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role
                ],
                'token' => $token,
                'remember' => $remember,
                'expires_in' => $expiration . ' minutes'
            ]
        ]);
    }

    // ✅ Logout - clear remember token
    public function logout(Request $request)
    {
        $user = $request->user();

        // ✅ Clear remember token
        $user->remember_token = null;
        $user->save();

        // ✅ Delete current token
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully'
        ]);
    }

    // ✅ Get current user
    public function user(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => $request->user()
        ]);
    }

    // ✅ Renew token (for long sessions)
    public function renew(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated'
            ], 401);
        }

        // Delete current token
        $user->currentAccessToken()->delete();

        // Create new token
        // $token = $user->createToken('auth_token')->plainTextToken;
        $token = $user->createToken(
            'auth_token',
            ['*'],
            now()->addMinutes(525600)  // 1 year
        )->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Token renewed!',
            'data' => [
                'token' => $token
            ]
        ]);
    }

    // ✅ Add change password method
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed'
        ]);

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect.'
            ], 400);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        // Optionally: Delete all tokens (force re-login)
        $user->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Password changed successfully! Please login again.'
        ]);
    }
}
