<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;

use App\Models\User;

use Closure;

class AuthenticateWithToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        
        if (!$request->bearerToken()) {

            return response()->json([
                'message' => 'Unauthorized'
            ], 401);

        }

        $user = User::where('token', $request->bearerToken())->first();

        if (is_null($user)) {

            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
            
        }

        return $next($request);

    }
}
