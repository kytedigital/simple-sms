<?php

namespace App\Http\Auth;

use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\User;
use Illuminate\Contracts\Auth\Authenticatable;

class TokenGuard implements Guard
{
    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function check() {
        return $this->getShopByToken(app(Request::class)->bearerToken());
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

    /**
     * Determine if the current user is a guest.
     *
     * @return bool
     */
    public function guest() {
        return false;
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user() {
        return new User();
    }

    /**
     * Get the ID for the currently authenticated user.
     *
     * @return int|null
     */
    public function id() {
        return 1;
    }

    /**
     * Validate a user's credentials.
     *
     * @param  array  $credentials
     * @return bool
     */
    public function validate(array $credentials = []) {
        return true;
    }

    /**
     * Set the current user.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @return void
     */
    public function setUser(Authenticatable $user) { }
}