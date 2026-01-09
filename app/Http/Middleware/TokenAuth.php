<?php

namespace App\Http\Middleware;

use App\Models\Teacher;
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

        if (!$token) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            return redirect()->route('login');
        }

        $teacher = Teacher::where('api_token', hash('sha256', $token))->first();

        if (!$teacher) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Invalid token'], 401);
            }
            session()->forget(['api_token', 'teacher_id']);
            return redirect()->route('login');
        }

        // Store teacher in request for later use
        $request->attributes->set('teacher', $teacher);

        return $next($request);
    }
}

