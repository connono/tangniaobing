<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function create(Request $request)
    {
        $this->validate($request, [
            'phoneNumber' => 'required|unique:users|regex:/^1[345789][0-9]{9}$/',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = User::create([
            'phoneNumber' => $request->phoneNumber,
            'password' => bcrypt($request->password)
        ]);

        return $user;
    }
}
