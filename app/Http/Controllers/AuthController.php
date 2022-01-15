<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where([
            'user_id' => $request->user_id,
        ])->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken($user->name);
            return $this->sendResponse('Login Success', $token, 200);
        } else {
            return $this->sendResponse('Login Fail', '', 401);
        }
    }

    public function logout(Request $request)
    {
        Auth::user()->currentAccessToken()->delete();
        return $this->sendResponse('Logout', '', 200);
    }
}
