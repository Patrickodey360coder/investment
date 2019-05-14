<?php

namespace App\Http\Controllers;

use App\Activity;
use App\TrustwayInvestment;
use App\TrustwayPensionInvestment;
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

    private function getTrustwayPensionAmount($amount, $years)
    {
        $capital = $amount;
        $totalEarning = 0;

        for($i=0; $i<$years; $i++){
            $totalEarning += $capital * 50/100;
            $capital += $capital * 25/100;
        }
        $totalEarning += $capital;  

        return $totalEarning;
    }

    private function getCheckoutAmount($investmentType, $amount, $duration=0)
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
                return $this->getTrustwayPensionAmount($amount, $duration);

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
        $duration = $request['duration'] ?? 0;
        $duration = (int) $duration;

        $investment = TrustwayInvestment::create([
        	'user_id' => Auth::user()['id'],
        	'investment_amount' => $amount,
        	'investment_type' => $request['investment-type'],
        	'checkout_amount' => $this->getCheckoutAmount($request['investment-type'], $amount, $duration)
        ]);

        $wallet->withdrawable = $wallet->withdrawable - $amount;
        $wallet->save();

        Activity::create([
        	'user_id' => Auth::user()['id'],
        	'detail' => "Created " . $request['investment-type'] . " investment with &#8358;" . $amount
        ]);

        if($request['investment-type'] == 'Trustway Pension'){
            TrustwayPensionInvestment::create([
                'trustway_investment_id' => $investment->id
            ]);
        }

    	Session::flash('success','Trustway investment successfully created.');

        return redirect()->route('user.investments');
    }

    public function createForm()
    {
    	$wallet = Auth::user()->wallet;
    	return view('user.create-trustway-investment')->with('investments', TrustwayInvestment::getInvestmentTypes())->with('wallet', $wallet)->with('activeLink', 'trustway');
    }
}
