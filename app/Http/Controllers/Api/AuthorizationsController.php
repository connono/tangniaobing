<?php

namespace App\Http\Controllers\Api;

use  App\Http\Requests\Api\AuthorizationRequest;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;


class AuthorizationsController extends Controller
{
    public function store (AuthorizationRequest $request)
    {
        $credentials['phoneNumber'] = $request->phoneNumber;
        $credentials['password'] = $request->password;

        if (!$token = Auth::guard('api')->attempt($credentials)) {
            throw new AuthenticationException('用户名或密码错误');
        }
        
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60
        ])->setStatusCode(201);
    }

    public function update()
    {
        $token = auth('api')->refresh();
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60
        ])->setStatusCode(201);
    }

    public function destroy()
    {
        auth('api')->logout();
       return response()->json([
           'message' => 'success'
       ])->setStatusCode(201);
    }
}
