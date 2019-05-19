<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\Models\Token;
use RuntimeException;
use Illuminate\Http\Request;
use App\Http\Helpers\Shopify;

class AuthenticateWithTokenAuth
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param  Closure $next
     * @param  string|null $guard
     * @return mixed
     * @throws \Throwable
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        try {
            throw_unless(
                $shop = $this->getShopByToken($request->bearerToken()),
                new RuntimeException("Can't find a shop with that token.")
            );
        } catch(Exception $e) {
            return response()->json(['message' => "Token is incorrect or the shop is not installed."], 401);
        }

        $request->merge(['shop' => Shopify::stemName($shop), 'shopUrl' => Shopify::nameToUrl($shop)]);

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
