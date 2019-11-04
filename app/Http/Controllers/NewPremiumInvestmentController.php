<?php

namespace App\Http\Controllers;

use App\NewPremiumInvestment;
use App\Activity;
use App\Rules\ValidateNewPremiumInvestmentAmount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
        $user = Auth::user();
        $premiumUser = $user->premiumUser;
        $wallet = $user->wallet;

    	$this->validate($request, [
            'amount' => ['required', 'numeric', 'min:200000', new ValidateNewPremiumInvestmentAmount($wallet)],
            'months' => ['required', 'numeric', 'min:6', 'max:24'],
            'from_wallet' => ['required', Rule::in('yes', 'no')],
        ]);

    	if(time() > strtotime($premiumUser->expiration_date)){
    		$amount = (int) $request->amount;
    		$months = (int) $request->months;
            $from_wallet = $request->from_wallet;

    		$newPremiumInvestment = $user->newPremiumInvestment;

    		if($newPremiumInvestment){
                if($newPremiumInvestment->from_wallet === 'yes'){
                    $wallet->withdrawable = $wallet->withdrawable + $newPremiumInvestment->investment_amount;
                    $wallet->save();
                }

    			$newPremiumInvestment->investment_amount = $amount;
    			$newPremiumInvestment->months = $months;
                $newPremiumInvestment->from_wallet = $from_wallet;
    			$newPremiumInvestment->save();
    		} else {
    			NewPremiumInvestment::create([
    				'investment_amount' => $amount,
    				'months' => $months,
    				'user_id' => $user->id,
                    'from_wallet' => $from_wallet
    			]);
    		}

            if($from_wallet === 'yes'){
                $wallet->withdrawable = $wallet->withdrawable - $amount;
                $wallet->save();
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
            if($reinitiationRequest->from_wallet === 'yes'){
                $wallet = $reinitiationRequest->user->wallet;
                $wallet->withdrawable = $wallet->withdrawable + $reinitiationRequest->investment_amount;
                $wallet->save();
            }

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
