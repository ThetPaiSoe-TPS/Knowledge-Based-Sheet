<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    // ============================================
    // STEP 1: Request Password Reset Link
    // ============================================
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $user = User::where('email', $request->email)->first();

        // Generate token
        $token = Str::random(60);

        // Store token in database
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => Hash::make($token),
                'created_at' => now()
            ]
        );

        // Update user
        $user->reset_password_sent_at = now();
        $user->save();

        // Send notification
        $user->notify(new \App\Notifications\ResetPasswordNotification($token));

        return response()->json([
            'success' => true,
            'message' => 'Password reset link sent to your email!',
            'data' => [
                'email' => $user->email,
                'sent_at' => $user->reset_password_sent_at
            ]
        ]);
    }

    // ============================================
    // STEP 2: Verify Token (Validate Reset Link)
    // ============================================
    public function verifyToken(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'token' => 'required|string'
        ]);

        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$resetRecord) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid reset request. Please request a new link.'
            ], 400);
        }

        // Check if token is expired (60 minutes)
        $expiresAt = Carbon::parse($resetRecord->created_at)->addMinutes(60);
        if (now()->greaterThan($expiresAt)) {
            return response()->json([
                'success' => false,
                'message' => 'Reset link has expired. Please request a new one.'
            ], 400);
        }

        // Verify token
        if (!Hash::check($request->token, $resetRecord->token)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid token. Please request a new reset link.'
            ], 400);
        }

        // Mark user as verified
        $user = User::where('email', $request->email)->first();
        $user->reset_password_verified_at = now();
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Token verified! You can now reset your password.',
            'data' => [
                'email' => $user->email,
                'verified_at' => $user->reset_password_verified_at
            ]
        ]);
    }

     // ============================================
    // STEP 3: Reset Password (Update New Password)
    // ============================================
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'token' => 'required|string',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$resetRecord) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid reset request.'
            ], 400);
        }

        // Check if token is expired (60 minutes)
        $expiresAt = Carbon::parse($resetRecord->created_at)->addMinutes(60);
        if (now()->greaterThan($expiresAt)) {
            return response()->json([
                'success' => false,
                'message' => 'Reset link has expired. Please request a new one.'
            ], 400);
        }

        // Verify token
        if (!Hash::check($request->token, $resetRecord->token)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid token.'
            ], 400);
        }

        // Update password
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Delete used token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        // Optionally: Delete all user tokens (force re-login)
        $user->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Password reset successfully! Please login with your new password.'
        ]);
    }

    // ============================================
    // STEP 4: Check Reset Status
    // ============================================
    public function checkStatus(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $user = User::where('email', $request->email)->first();

        return response()->json([
            'success' => true,
            'data' => [
                'email' => $user->email,
                'reset_sent_at' => $user->reset_password_sent_at,
                'reset_verified_at' => $user->reset_password_verified_at,
                'is_verified' => $user->reset_password_verified_at ? true : false
            ]
        ]);
    }
}
