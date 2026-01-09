<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

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
}

