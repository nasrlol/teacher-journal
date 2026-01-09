<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Log;

class AuthController extends Controller
{
    /**
     * Show login form.
     */
    public function showLogin(): View
    {
        return view('auth.login');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'remember' => 'nullable|boolean',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }
            return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
        }

        // Generate token
        $token = Str::random(60);
        $user->api_token = hash('sha256', $token);
        $user->save();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
                'user' => $user,
            ]);
        }

        // Store token in session for web
        session(['api_token' => $token, 'user_id' => $user->id]);

        // Handle "Remember me"
        $response = redirect()->route('dashboard');
        if ($request->boolean('remember')) {
            $response->withCookie(cookie('remember_token', $token, 60 * 24 * 30)); // 30 days
        }

        return $response;
    }

    /**
     * Show registration form.
     */
    public function showRegister(): View
    {
        return view('auth.register');
    }

    /**
     * Handle registration request.
     */
    public function register(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        // Generate token
        $token = Str::random(60);
        $validated['api_token'] = hash('sha256', $token);

        $user = User::create($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Registration successful',
                'token' => $token,
                'user' => $user,
            ], 201);
        }

        session(['api_token' => $token, 'user_id' => $user->id]);

        return redirect()->route('dashboard');
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request): JsonResponse|RedirectResponse
    {
        $user = $request->attributes->get('user');

        if ($user) {
            $user->api_token = null;
            $user->save();
        }

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Logged out successfully']);
        }

        session()->forget(['api_token', 'user_id']);

        return redirect()->route('login')->withCookie(Cookie::forget('remember_token'));
    }

    /**
     * Get current authenticated user.
     */
    public function me(Request $request): JsonResponse
    {
        $user = $request->attributes->get('user');
        return response()->json($user);
    }

    /**
     * Show forgot password form.
     */
    public function showForgotPassword(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Send password reset link.
     */
    public function sendResetLink(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $token = Str::random(64);

        // Delete any existing tokens for this email
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        // Store new token
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => Hash::make($token),
            'created_at' => now(),
        ]);

        // Send email with reset link
        $resetUrl = route('password.reset', ['token' => $token, 'email' => $request->email]);

        try {
            Mail::raw(
                "You requested a password reset. Click the link below to reset your password:\n\n" .
                "{$resetUrl}\n\n" .
                "This link will expire in 60 minutes.\n\n" .
                "If you did not request this reset, please ignore this email.",
                function ($mail) use ($request) {
                    $mail->to($request->email)
                        ->subject('Password Reset Request - Teacher Journal');
                }
            );
        } catch (Exception $e) {
            Log::error('Failed to send password reset email: ' . $e->getMessage());
        }

        return back()->with('success', 'Password reset link has been sent to your email.');
    }

    /**
     * Show reset password form.
     */
    public function showResetPassword(Request $request, string $token): View
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    /**
     * Reset password.
     */
    public function resetPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Find the token
        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$resetRecord || !Hash::check($request->token, $resetRecord->token)) {
            return back()->withErrors(['email' => 'Invalid or expired reset token.']);
        }

        // Check if token is expired (60 minutes)
        if (now()->diffInMinutes($resetRecord->created_at) > 60) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return back()->withErrors(['email' => 'Reset token has expired.']);
        }

        // Update password
        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password),
        ]);

        // Delete the token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Password has been reset successfully. Please login.');
    }
}

