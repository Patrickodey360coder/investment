<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Validator;
use Hash;
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
            if($user->role === 'user'){
	            $res['user'] = $user;
                $res['wallet'] = $user->wallet;
                $res['bank'] = $user->bankAccount;
	            $res['token'] = $user->createToken('web-ui-api')->accessToken;

                $investmentsCount = count($user()->trustwayInvestments);
                $activeInvestment = DB::table('trustway_investments')->where('user_id', $userId)->where('status', 'Active')->sum('investment_amount');
                $pendingInvestment = DB::table('trustway_investments')->where('user_id', $userId)->where('status', 'Pending')->sum('investment_amount');
                $closedInvestment = DB::table('trustway_investments')->where('user_id', $userId)->where('status', 'Closed')->sum('investment_amount');

                $pendingWithdrawal = DB::table('withdrawals')->where('user_id', $userId)->where('status', 'Pending')->sum('amount');
                $paidWithdrawal = DB::table('withdrawals')->where('user_id', $userId)->where('status', 'Paid')->sum('amount');

                $res['home'] = [
                    'investments' => [
                        'count' => $investmentsCount,
                        'active' => $activeInvestment,
                        'pending' => $pendingInvestment,
                        'closed' => $closedInvestment,
                    ],
                    'withdrawals' => [
                        'pending' => $pendingWithdrawal,
                        'paid' => $paidWithdrawal
                    ]
                ];

	            return response()->json($res, 200);
	        } else {
                return response()->json([
                  'error' => strtoupper($user->role) . ' users must use the website',
                ], 400);
            }
        }

        return response()->json(['error' => 'Incorrect email and password'], 401);
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
        $wallet = Wallet::create([
            'user_id' => $user->id,
            'total_earnings' => 0,
            'balance' => 0,
            'bonus' => 0,
            'withdrawable' => 0,
        ]);

        $bank = BankAccount::create([
            'user_id' => $user->id,
            'bank_name' => '',
            'account_name' => '',
            'account_number' => '',
        ]);

        $res['user'] = $user;
        $res['wallet'] = $wallet;
        $res['bank'] = $bank;
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

    public function forgotPassword(Request $request){
        $validator = Validator::make($request->input(), [
          'email' => [
            'required',
            'email',
            'exists:users,email',
          ]
        ]);

        $user = User::where('email', '=', $_POST['email']??'')->first();

        if (empty($user)) {
            return response()->json([
              'error' => 'Your email does not exist in our database',
            ], 400);
        }

        $password = $this->genPassword(8);
        // SEND EMAIL CONTAINING PASSWORD

        $user->password = Hash::make($password);
        $user->save();

        Activity::create([
            'user_id' => $user->id,
            'detail' => "Reset password"
        ]);

        return response()->json([
            'message' => "An email has been sent containg your new password"
        ]);
    }

    private function genPassword(int $length, string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'): ?string
    {
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces []= $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->input(), [
            'current-password' => [
                'required',
            ],
            'new-password' => [
                'required',
                'min:8',
                'string',
            ],
            'confirm-password' => [
                'required',
                'same:new-password',
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
            ], 400);
        }

        $user = $request->user();

        if (!Hash::check($request['current-password'], $user->getAuthPassword())) {
            return response()->json([
                'error' => [
                    'The current password is incorrect.',
                ],
            ], 400);
        }

        $user->password = Hash::make($request->input('new-password'));
        $user->save();

        Activity::create([
            'user_id' => $user->id,
            'detail' => "Updated password"
        ]);

        return response()->json([
            'message' => 'Password updated successfully',
        ], 200);
    }
}
