<?php

namespace App\Http\Middleware;

use App\Http\Responses\Response;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::user()->role == "admin"){
            return $next($request);
        }
        return Response::Error('yoy do not have permission to access',403);

    }
}
