<?php

namespace App\Http\Controllers;

use App\Activity;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Session;

class PaymentController extends Controller
{
    public function index()
    {
    	return view('user.payment')->with('activeLink', 'payment');
    }

    public function addPayment(Request $request, $id)
    {
    	$this->validate($request, [
            'amount' => ['required', 'numeric', 'min:0']
        ]);

    	$user = User::find($id);
    	if(!empty($user) && $user->role == 'user'){
    		$wallet = $user->wallet;
    		$wallet->balance += (int) $request->amount;
    		$wallet->withdrawable += (int) $request->amount;
    		//$wallet->total_earnings += (int) $request->amount;
    		$wallet->save();

    		Activity::create([
                'user_id' => Auth::user()['id'],
                'detail' => "You added an incoming payment of &#8358;" . $request->amount . " from " . $user->name . "(" . $user->email . ")"
            ]);

    		Activity::create([
                'user_id' => $user->id,
                'detail' => "You were added the sum of &#8358;" . $request->amount
            ]);

    		Session::flash('success', "Successfully added money to " . $user->name);
    	} else {
    		Session::flash('error', "Could not add the payment detail");
    	}

    	return redirect()->route('admin.investors');
    }
}
