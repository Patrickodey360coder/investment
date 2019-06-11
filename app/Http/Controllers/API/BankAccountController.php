<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Activity;

class BankAccountController extends Controller
{
    public function index(Request $request)
    {
    	return response()->json([
            'bank' => $request->user()->bankAccount,
        ], 200);
    }

    public function create(Request $request)
    {
    	$validator = Validator::make($request->input(), [
          'account_name' => [
            'required',
            'string',
            'max:255',
          ],
          'account_number' => [
            'required',
            'numeric',
            'min:1',
          ],
          'bank_name' => [
            'required',
            'string',
            'max:255',
          ]
        ]);

        if ($validator->fails()) {
            return response()->json([
              'error' => $validator->errors(),
            ], 400);
        }
        $bank = $request->user()->bankAccount;
        $bank['bank_name'] = $request->bank_name;
        $bank['account_name'] = $request->account_name;
        $bank['account_number'] = $request->account_number;
        $bank->save();

        $user_id = $request->user()->id;

        Activity::create([
        	'user_id' => $user_id,
        	'detail' => "Updated bank account details"
        ]);

        return response()->json([
            'bank' => $bank,
        ], 200);
    }
}
