<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    public function login(Request $request)
    {
        // Attempt to login using web auth guard
        if (auth()->attempt(['email' => request('email'), 'password' => request('password')])) {
            // If it succeeds generate and return api token
            $user = auth()->user();
            if($user->role === 'user' || $user->role === 'premium'){
	            $res['user'] = $user;
	            $res['token'] = auth()->user()->createToken('web-ui-api')->accessToken;

	            return response()->json($res, 200);
	        }
        }

        return response()->json(['error' => 'Unauthorised'], 401);
    }
}
