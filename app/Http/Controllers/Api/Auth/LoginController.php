<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\LoginRequest;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;

/**
 * @group Authentication
 */
class LoginController extends AuthController
{
    /**
     * POST Login.
     */
    public function authenticate(LoginRequest $request)
    {
        return AuthService::authenticate($request);
    }

    /**
     * POST Logout.
     *
     * @authenticated
     */
    public function logout(Request $request)
    {
        return AuthService::logout($request);
    }
}
