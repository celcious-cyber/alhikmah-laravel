<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\TokenService;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateToken
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authorization = $request->header('Authorization');

        if (!$authorization || !str_starts_with($authorization, 'Bearer ')) {
            return response()->json(['message' => 'Token tidak ditemukan atau tidak valid.'], 401);
        }

        $token = substr($authorization, 7);
        $admin = TokenService::verify($token);

        if (!$admin) {
            return response()->json(['message' => 'Sesi tidak valid atau telah berakhir.'], 401);
        }

        // Log the admin in for the request lifecycle
        Auth::login($admin);

        // Share admin model directly with the request object
        $request->merge(['admin' => $admin]);

        return $next($request);
    }
}
