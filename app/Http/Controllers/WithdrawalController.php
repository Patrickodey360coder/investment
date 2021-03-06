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
    	$user_id = Auth::user()['id'];
    	
    	$this->validate($request, [
            'amount' => ['required', 'numeric', 'min:0', 'max:'.$wallet->withdrawable],
        ]);

        $amount = (int) $request->amount;

        Withdrawal::create([
        	'amount' => $amount,
        	'user_id' => $user_id,
        ]);

        $wallet->withdrawable = $wallet->withdrawable - $amount;
        $wallet->save();

        Activity::create([
        	'user_id' => $user_id,
        	'detail' => "Made a withdrawal request of &#8358;" . $amount
        ]);

    	Session::flash('success','Successfully made a withdrawal request.');

        return redirect()->route('user.withdrawals');
    }

    public function delete(Request $request, $id)
    {
    	$user_id = Auth::user()['id'];
    	$withdrawal = Withdrawal::find($id);
    	$withdrawal = (!empty($withdrawal) && $withdrawal['status'] == "Pending" && $withdrawal['user_id'] == $user_id) ? $withdrawal : null;
    	
    	if($withdrawal){
    		$amount = (int) $withdrawal['amount'];
    		
    		$withdrawal->delete();

    		$wallet = Auth::user()->wallet;
    		$wallet->withdrawable = $wallet->withdrawable + $amount;
        	$wallet->save();

    		Activity::create([
	        	'user_id' => $user_id,
	        	'detail' => "Canceled your withdrawal request of &#8358;" . $amount
	        ]);

    		Session::flash('success','Successfully canceled your withdrawal request.');
    	} else {
    		Session::flash('error', "Could not find the requested withdrawal request");
    	}
    	return redirect()->route('user.withdrawals');
    }

    public function show()
    {
        return view('admin.withdrawal')->with('withdrawals', Withdrawal::all())->with('activeLink', 'withdrawal');
    }

    public function accept(Request $request, $id)
    {
        $withdrawal = Withdrawal::find($id);
        $withdrawal = (!empty($withdrawal) && $withdrawal['status'] == "Pending") ? $withdrawal : null;
        
        if($withdrawal){
            $amount = (int) $withdrawal['amount'];
            
            $withdrawal->status = 'Paid';
            $withdrawal->save();

            $wallet = $withdrawal->user->wallet;
            $wallet->balance = $wallet->balance - $amount;
            $wallet->save();

            Activity::create([
                'user_id' => Auth::user()['id'],
                'detail' => "You accepted withdrawal request #" . $withdrawal->id . " of &#8358;" . $amount
            ]);

            Session::flash('success','Successfully accepted the requested withdrawal request.');
        } else {
            Session::flash('error', "Could not accept the requested withdrawal request");
        }
        return redirect()->route('admin.withdrawals');
    }

    public function reject(Request $request, $id)
    {
        $withdrawal = Withdrawal::find($id);
        $withdrawal = (!empty($withdrawal) && $withdrawal['status'] == "Pending") ? $withdrawal : null;
        
        if($withdrawal){
            $amount = (int) $withdrawal['amount'];
            
            $withdrawal->status = 'Rejected';
            $withdrawal->save();

            $wallet = $withdrawal->user->wallet;
            $wallet->withdrawable = $wallet->withdrawable + $amount;
            $wallet->save();

            Activity::create([
                'user_id' => Auth::user()['id'],
                'detail' => "You canceled withdrawal request #" . $withdrawal->id . " of &#8358;" . $amount
            ]);

            Session::flash('success','Successfully rejected the requested withdrawal request.');
        } else {
            Session::flash('error', "Could not reject the requested withdrawal request");
        }
        return redirect()->route('admin.withdrawals');
    }
}
