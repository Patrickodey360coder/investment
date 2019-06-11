<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WithdrawalInvestmentController extends Controller
{
    public function index(Request $request)
    {
    	return response()->json([
            'withdrawals' => $request->user()->withdrawals,
        ], 200);
    }
}
