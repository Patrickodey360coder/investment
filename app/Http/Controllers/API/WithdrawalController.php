<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Activity;
use App\Withdrawal;

class WithdrawalController extends Controller
{
    public function index(Request $request)
    {
    	return response()->json([
            'withdrawals' => $request->user()->withdrawals,
        ], 200);
    }

    public function create(Request $request)
    {
    	$wallet = $request->user()->wallet;

        $validator = Validator::make($request->input(), [
          'amount' => [
            'required',
            'numeric',
            'min:1',
            'max:'.$wallet->withdrawable
          ]
        ]);

        if ($validator->fails()) {
            return response()->json([
              'error' => $validator->errors(),
            ], 400);
        }

        $amount = (int) $request->amount;
        $user_id = $request->user()->id;

        $withdrawal = Withdrawal::create([
        	'amount' => $amount,
        	'user_id' => $user_id,
        ]);

        $wallet->withdrawable = $wallet->withdrawable - $amount;
        $wallet->save();

        Activity::create([
        	'user_id' => $user_id,
        	'detail' => "Made a withdrawal request of &#8358;" . $amount
        ]);

        return response()->json([
            'wallet' => $wallet,
            'withdrawal' => $withdrawal
        ], 200);
    }
}
