<?php

namespace App\Http\Controllers;

use App\User;
use App\Wallet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()['role'] == 'admin'){
            $totalInvestment = DB::table('trustway_investments')->sum('investment_amount');
            $activeInvestment = DB::table('trustway_investments')->where('status', 'Active')->sum('investment_amount');
            $pendingInvestment = DB::table('trustway_investments')->where('status', 'Pending')->sum('investment_amount');
            $closedInvestment = $totalInvestment - $activeInvestment - $pendingInvestment;

            $pendingWithdrawal = DB::table('withdrawals')->where('status', 'Pending')->sum('amount');
            $paidWithdrawal = DB::table('withdrawals')->where('status', 'Paid')->sum('amount');
            $totalWithdrawal = $pendingWithdrawal + $paidWithdrawal;

            $allUsers = User::all();
            $investors = count($allUsers->where('role', 'user'));
            $admins = count($allUsers->where('role', 'admin'));
            return view('admin.home')->with('admins', $admins)->with('investors', $investors)->with('totalInvestment', $totalInvestment)->with('totalWithdrawal', $totalWithdrawal)->with('activeInvestment', $activeInvestment)->with('pendingInvestment', $pendingInvestment)->with('closedInvestment', $closedInvestment)->with('pendingWithdrawal', $pendingWithdrawal)->with('paidWithdrawal', $paidWithdrawal)->with('totalWithdrawal', $totalWithdrawal);
        }

        $userId = Auth::user()['id'];
        if(Auth::user()['role'] == 'premium'){
            $investmentsCount = 1;
        } else {
            $investmentsCount = count(Auth::user()->trustwayInvestments);
        }

        $activeInvestment = DB::table('trustway_investments')->where('user_id', $userId)->where('status', 'Active')->sum('investment_amount');
        $pendingInvestment = DB::table('trustway_investments')->where('user_id', $userId)->where('status', 'Pending')->sum('investment_amount');
        $closedInvestment = DB::table('trustway_investments')->where('user_id', $userId)->where('status', 'Closed')->sum('investment_amount');

        $pendingWithdrawal = DB::table('withdrawals')->where('user_id', $userId)->where('status', 'Pending')->sum('amount');
        $paidWithdrawal = DB::table('withdrawals')->where('user_id', $userId)->where('status', 'Paid')->sum('amount');

        $wallet = Wallet::all()->where('user_id', $userId)->first();
        return view('user.home')->with('wallet', $wallet)->with('activeInvestment', $activeInvestment)->with('pendingInvestment', $pendingInvestment)->with('closedInvestment', $closedInvestment)->with('pendingWithdrawal', $pendingWithdrawal)->with('paidWithdrawal', $paidWithdrawal)->with('investments', $investmentsCount)->with('user', Auth::user());
    }
}
