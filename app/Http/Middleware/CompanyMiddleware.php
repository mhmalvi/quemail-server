<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CompanyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $auth = Auth::where('token', $request->bearerToken())->first();
        dd($auth);
        if ($auth->role_id == 3) {
            return $next($request);
        } else {
            return response()->json(['Unauthenticated']);
        }
    }
}
