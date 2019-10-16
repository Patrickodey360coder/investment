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

    public function accept(Request $request, $id)
    {
    	$reinitiationRequest = NewPremiumInvestment::find($id);
    	if($reinitiationRequest)
    	{
    		$premiumUser = $reinitiationRequest->user->premiumUser;
    		$premiumUser->investment_amount = $reinitiationRequest->investment_amount;
    		$premiumUser->months = $reinitiationRequest->months;
    		$premiumUser->next_checkout_date = strftime("%Y-%m-%d 00:00:00", strtotime('+1 months', time()));
    		$premiumUser->expiration_date = strftime("%Y-%m-%d 00:00:00", strtotime('+' . $reinitiationRequest->months .' months', time()));
    		$premiumUser->save();

    		$reinitiationRequest->delete();

    		Activity::create([
                'user_id' => Auth::user()['id'],
                'detail' => "You accepted a premium investment reinitiation request of &#8358;".$reinitiationRequest->investment_amount." lasting ".$reinitiationRequest->months." months from user #".$reinitiationRequest->user_id
            ]);

            Activity::create([
                'user_id' =>$reinitiationRequest['user_id'],
                'detail' => "Your premium investment reinitiation request of &#8358;".$reinitiationRequest->investment_amount." lasting ".$reinitiationRequest->months." months was accepted."
            ]);

            Session::flash('success', "Successfully accepted the selected premium investment reinitiation request");
    	} else {
    		Session::flash('error', "Could not reject the selected premium investment reinitiation request");
    	}

    	return redirect()->route('admin.premium.reinitiatePremiumInvestment');
    }

    public function reject(Request $request, $id)
    {
    	$reinitiationRequest = NewPremiumInvestment::find($id);
    	if($reinitiationRequest)
    	{
    		$reinitiationRequest->delete();

    		Activity::create([
                'user_id' => Auth::user()['id'],
                'detail' => "You rejected a premium investment reinitiation request of &#8358;".$reinitiationRequest->investment_amount." lasting ".$reinitiationRequest->months." months from user #".$reinitiationRequest->user_id
            ]);

            Activity::create([
                'user_id' =>$reinitiationRequest['user_id'],
                'detail' => "Your premium investment reinitiation request of &#8358;".$reinitiationRequest->investment_amount." lasting ".$reinitiationRequest->months." months was rejected."
            ]);

            Session::flash('success', "Successfully rejected the selected premium investment reinitiation request");
    	} else {
    		Session::flash('error', "Could not reject the selected premium investment reinitiation request");
    	}

    	return redirect()->route('admin.premium.reinitiatePremiumInvestment');
    }
}
