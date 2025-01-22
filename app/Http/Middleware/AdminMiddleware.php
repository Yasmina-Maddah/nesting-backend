<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        try {
            // Debug JWT token parsing
            dd(JWTAuth::parseToken()->getPayload());
    
            $user = JWTAuth::parseToken()->authenticate();
    
            // Debug the authenticated user
            dd($user);
    
            if ($user->user_type !== 'admin') {
                return response()->json(['error' => 'Access denied'], 403);
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['error' => 'Token has expired'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['error' => 'Token is invalid'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['error' => 'Token not found'], 401);
        }
    
        return $next($request);
    }
}    
