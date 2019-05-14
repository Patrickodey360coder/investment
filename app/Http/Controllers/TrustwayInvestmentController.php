<?php

namespace App\Http\Controllers;

use App\Activity;
use App\TrustwayInvestment;
use App\Rules\InvestmentMinAndMaxAmount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Session;

class TrustwayInvestmentController extends Controller
{
    public function index()
    {
    	return view('user.trustway-investment')->with('trustwayInvestments', Auth::user()->trustwayInvestments)->with('activeLink', 'trustway');
    }

    private function getCheckoutAmount($investmentType, $amount)
    {
    	$amount = (int) $amount;
    	switch ($investmentType) {
            case 'Trustway 90':
                return $amount + ($amount * 12/100);

            case 'Trustway 180':
                return $amount + ($amount * 30/100);

            case 'Trustway 360':
                return $amount + ($amount * 75/100);

            case 'Trustway Pension':
                return 0;

            default:
                return 0;
        }
    }

    public function store(Request $request)
    {
    	$wallet = Auth::user()->wallet;
    	
    	$this->validate($request, [
            'investment-type' => ['required', Rule::in(TrustwayInvestment::getInvestmentTypes())],
            'amount' => ['required', 'numeric', 'max:'.$wallet->withdrawable , new InvestmentMinAndMaxAmount],
            'duration' => ['required_if:investment-type,Trustway Pension', 'between:2,5', 'integer']
            
        ]);
        $amount = (int) $request->amount;

        TrustwayInvestment::create([
        	'user_id' => Auth::user()['id'],
        	'investment_amount' => $amount,
        	'investment_type' => $request['investment-type'],
        	'checkout_amount' => $this->getCheckoutAmount($request['investment-type'], $amount)
        ]);

        $wallet->withdrawable = $wallet->withdrawable - $amount;
        $wallet->save();

        Activity::create([
        	'user_id' => Auth::user()['id'],
        	'detail' => "Created " . $request['investment-type'] . " investment with &#8358;" . $amount
        ]);

    	Session::flash('success','Trustway investment successfully created.');

        return redirect()->route('user.investments');
    }

    public function createForm()
    {
    	$wallet = Auth::user()->wallet;
    	return view('user.create-trustway-investment')->with('investments', TrustwayInvestment::getInvestmentTypes())->with('wallet', $wallet)->with('activeLink', 'trustway');
    }
}
