<?php

namespace App\Http\Controllers;

use App\NewPremiumInvestment;
use App\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Session;

class NewPremiumInvestmentController extends Controller
{
    public function index()
    {
    	$premiumUser = Auth::user()->premiumUser;
    	$canReinitiate = time() > strtotime($premiumUser->expiration_date);
    	return view('premium.reinitiateInvestment')->with('canReinitiate', true)->with('activeLink', 'reinitiateInvestment');
    }

    public function save(Request $request)
    {
    	$this->validate($request, [
            'amount' => ['required', 'numeric', 'min:200000'],
            'months' => ['required', 'numeric', 'min:6', 'max:24'],
        ]);

    	$user = Auth::user();
    	$premiumUser = $user->premiumUser;
    	if(time() > strtotime($premiumUser->expiration_date)){
    		$amount = (int) $request->amount;
    		$months = (int) $request->months;

    		$newPremiumInvestment = $user->newPremiumInvestment;
    		if($newPremiumInvestment){
    			$newPremiumInvestment->investment_amount = $amount;
    			$newPremiumInvestment->months = $months;
    			$newPremiumInvestment->save();
    		} else {
    			NewPremiumInvestment::create([
    				'investment_amount' => $amount,
    				'months' => $months,
    				'user_id' => $user->id
    			]);
    		}

    		Activity::create([
	        	'user_id' => $user->id,
	        	'detail' => "You created an investment reinitiation request of &#8358;" . $amount
        	]);

    		Session::flash('success','Investment reinitiation request created, please wait for the administrator to approve it');

        	return redirect()->route('premium.reinitiateInvestment');
    	}

    	Session::flash('error','Sorry you have a running investment. Please contact the administrator to top up your investment');

        return redirect()->route('premium.reinitiateInvestment');
    }

    public function show()
    {
    	return view('admin.newPremiumInvestment')->with('requests', NewPremiumInvestment::all())->with('activeLink', 'reinitiateInvestment');
    }
}
