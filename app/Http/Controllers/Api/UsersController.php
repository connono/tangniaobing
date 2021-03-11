<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Requests\Api\UserRequest;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class UsersController extends Controller
{
    public function store(UserRequest $request)
    {
        $verifyData = Cache::get($request->verification_key);
        if (!$verifyData) {
            abort(403, '验证码已失效');
        }

        if (!hash_equals($verifyData['code'], $request->verification_code)) {
            throw new AuthenticationException("验证码错误");
        }

        $user = User::create([
            'phoneNumber' => $verifyData['phoneNumber'],
            'password' => bcrypt($request->password),
        ]);

        Cache::forget($request->verification_key);

        return new UserResource($user);
    }

    public function show(Request $request)
    {
        return new UserResource($request->user());
    }
}
