<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Token;

class AuthenticateWithTokenAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if(!$request->bearerToken() || !$shop = $this->getShopByToken($request->bearerToken())) {
            return response()->json(['message' => 'Couldn\'t validate auth token. 
            Token is incorrect or the shop is not installed.'], 401);
        }

        $request->merge(['shop' => $shop]);

        return $next($request);
    }

    /**
     * Get shop name using token.
     *
     * @param $token
     * @return String
     */
    private function getShopByToken($token) : string
    {
        $token = Token::where('token', $token)->where('type', 'app-api')->first();

        if(!$token) {
            return false;
        }

        return $token->shop;
    }
}
