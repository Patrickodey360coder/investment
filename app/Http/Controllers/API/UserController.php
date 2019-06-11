<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Validator;
use App\User;
use App\BankAccount;
use App\Wallet;
use App\Activity;

require '../resources/countries.php';

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

    public function register(Request $request)
    {
        $validator = Validator::make($request->input(), [
          'name' => [
            'required',
            'string',
            'max:255',
          ],
          'country' => [
          	'required',
          	Rule::in(Countries)
          ],
          'email' => [
            'required',
            'email',
            'unique:users,email',
          ],
          'password' => [
            'required',
            'min:8',
            'string',
            'max:255',
          ]
        ]);

        if ($validator->fails()) {
            return response()->json([
              'error' => $validator->errors(),
            ], 400);
        }

        $input = [
          'name' => $request['name'],
          'email' => $request['email'],
          'country' => $request['country'],
          'password' => bcrypt($request['password']),
        ];

        $user = User::create($input);
        Wallet::create([
            'user_id' => $user->id,
            'total_earnings' => 0,
            'balance' => 0,
            'bonus' => 0,
            'withdrawable' => 0,
        ]);

        BankAccount::create([
            'user_id' => $user->id,
            'bank_name' => '',
            'account_name' => '',
            'account_number' => '',
        ]);

        $res['user'] = $user;
        $res['token'] = $user->createToken('web-ui-api')->accessToken;

        return response()->json($res, 200);
    }

    public function logout(Request $request)
    {
        if (\array_key_exists('reset-all', $request->all()) &&
            $request->all()['reset-all'] == 'true') {
            $this->logoutAll();

            return response()->json([
                'message' => 'Tokens deleted successfully.',
            ], 200);
        }

        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Logout successful.',
        ], 200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->input(), [
          'name' => [
            'required',
            'string',
            'max:255',
          ],
          'country' => [
            'required',
            Rule::in(Countries)
          ]
        ]);

        if ($validator->fails()) {
            return response()->json([
              'error' => $validator->errors(),
            ], 400);
        }

        $user = $request->user();
        $user->name = $request['name'];
        $user->country = $request['country'];
        $user->save();

        Activity::create([
            'user_id' => $user->id,
            'detail' => "Updated profile"
        ]);

        return response()->json([
            'user' => $user,
            'message' => 'Profile updated successfully.',
        ], 200);
    }
}
