<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = null;

        // Check for Bearer token in Authorization header (API)
        if ($request->hasHeader('Authorization')) {
            $auth = $request->header('Authorization');
            if (str_starts_with($auth, 'Bearer ')) {
                $token = substr($auth, 7);
            }
        }

        // Check session for web requests
        if (!$token && session()->has('api_token')) {
            $token = session('api_token');
        }

        // Check "Remember me" cookie
        if (!$token && $request->cookie('remember_token')) {
            $token = $request->cookie('remember_token');
            // Restore session from remember token
            session(['api_token' => $token]);
        }

        if (!$token) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            return redirect()->route('login');
        }

        $user = User::where('api_token', hash('sha256', $token))->first();

        if (!$user) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Invalid token'], 401);
            }
            session()->forget(['api_token', 'user_id']);
            return redirect()->route('login');
        }

        // Store user in request for later use
        $request->attributes->set('user', $user);

        return $next($request);
    }
}

