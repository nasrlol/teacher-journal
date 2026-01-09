<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        ]);

        $teacher = Teacher::where('email', $validated['email'])->first();

        if (!$teacher || !Hash::check($validated['password'], $teacher->password)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }
            return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
        }

        // Generate token
        $token = Str::random(60);
        $teacher->api_token = hash('sha256', $token);
        $teacher->save();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
                'teacher' => $teacher,
            ]);
        }

        // Store token in session for web
        session(['api_token' => $token, 'teacher_id' => $teacher->id]);

        return redirect()->route('dashboard');
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
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        // Generate token
        $token = Str::random(60);
        $validated['api_token'] = hash('sha256', $token);

        $teacher = Teacher::create($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Registration successful',
                'token' => $token,
                'teacher' => $teacher,
            ], 201);
        }

        session(['api_token' => $token, 'teacher_id' => $teacher->id]);

        return redirect()->route('dashboard');
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request): JsonResponse|RedirectResponse
    {
        $teacher = $request->attributes->get('teacher');

        if ($teacher) {
            $teacher->api_token = null;
            $teacher->save();
        }

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Logged out successfully']);
        }

        session()->forget(['api_token', 'teacher_id']);

        return redirect()->route('login');
    }

    /**
     * Get current authenticated teacher.
     */
    public function me(Request $request): JsonResponse
    {
        $teacher = $request->attributes->get('teacher');
        return response()->json($teacher);
    }
}

