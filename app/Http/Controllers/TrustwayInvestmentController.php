<?php

namespace App\Http\Controllers;

use App\TrustwayInvestment;
use App\Wallet;
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
    	return view('user.trustway-investment');
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
    	$wallet = Wallet::all()->where('user_id', Auth::user()['id'])->first();
    	//dd($wallet->withdrawable);
    	$this->validate($request, [
            'investment-type' => ['required', Rule::in(TrustwayInvestment::getInvestmentTypes())],
            'amount' => ['required', 'numeric', 'max:'.$wallet->withdrawable , new InvestmentMinAndMaxAmount],
            'duration' => ['required_if:investment-type,Trustway Pension', 'between:2,5', 'integer']
            // 'password' => 'required|string|min:8|confirmed',
        ]);
        $amount = (int) $request->amount;

        //dd(Auth::user()->wallet());

        TrustwayInvestment::create([
        	'user_id' => Auth::user()['id'],
        	'investment_amount' => $amount,
        	'investment_type' => $request['investment-type'],
        	'checkout_amount' => $this->getCheckoutAmount($request['investment-type'], $amount)
        ]);
        $wallet->withdrawable = $wallet->withdrawable - $amount;
        $wallet->save();

    	Session::flash('success','Trustway investment successfully created.');

        return redirect()->route('user.investments');
    }

    public function createForm()
    {
    	$wallet = Wallet::all()->where('user_id', Auth::user()['id'])->first();
    	return view('user.create-trustway-investment')->with('investments', TrustwayInvestment::getInvestmentTypes())->with('wallet', $wallet);
    }
}
