<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class WithdrawalController extends Controller
{
    public function index()
    {
    	return view('user.withdrawal')->with('withdrawals', Auth::user()->withdrawals)->with('activeLink', 'withdrawal')->with('wallet', Auth::user()->wallet);
    }

    public function create(Request $request)
    {
    	$wallet = Auth::user()->wallet;
    	
    	$this->validate($request, [
            'amount' => ['required', 'numeric', 'max:'.$wallet->withdrawable],
        ]);

        $amount = (int) $request->amount;

        Withdrawal::create([
        	'amount' => $amount,
        	'user_id' => Auth::user()['id'],
        ]);

        $wallet->withdrawable = $wallet->withdrawable - $amount;
        $wallet->save();

        Activity::create([
        	'user_id' => Auth::user()['id'],
        	'detail' => "Made a withdrawal request of &#8358;" . $amount
        ]);

    	Session::flash('success','Successfully made a withdrawal request.');

        return redirect()->route('user.withdrawals');
    }
}
