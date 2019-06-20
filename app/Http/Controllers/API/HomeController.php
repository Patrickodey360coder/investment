<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index(Request $request)
    {
    	$user = $request->user();
    	$userId =$user['id'];

    	$investmentsCount = count($user()->trustwayInvestments);
    	$activeInvestment = DB::table('trustway_investments')->where('user_id', $userId)->where('status', 'Active')->sum('investment_amount');
        $pendingInvestment = DB::table('trustway_investments')->where('user_id', $userId)->where('status', 'Pending')->sum('investment_amount');
        $closedInvestment = DB::table('trustway_investments')->where('user_id', $userId)->where('status', 'Closed')->sum('investment_amount');

        $pendingWithdrawal = DB::table('withdrawals')->where('user_id', $userId)->where('status', 'Pending')->sum('amount');
        $paidWithdrawal = DB::table('withdrawals')->where('user_id', $userId)->where('status', 'Paid')->sum('amount');

        $res = [
            'user' => $user,
            'home' => [
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
            ],
            'bank' => $user->bankAccount,
            'wallet' => $user->wallet
        ]

    	return response()->json($res, 200);
    }
}
