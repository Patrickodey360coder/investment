<?php

namespace App\Http\Controllers\API;
use App\Activity;
use App\TrustwayInvestment;
use App\TrustwayPensionInvestment;
use App\Rules\InvestmentMinAndMaxAmount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class TrustwayInvestmentController extends Controller
{
    public function index(Request $request)
    {
    	return response()->json([
            'investments' => $request->user()->trustwayInvestments,
        ], 200);
    }

    private function getTrustwayPensionAmount($amount, $years)
    {
        $capital = $amount;
        $totalEarning = 0;

        for($i=0; $i<$years; $i++){
            $totalEarning += $capital * 75/100;
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
                return $amount + ($amount * 15/100);

            case 'Trustway 180':
                return $amount + ($amount * 40/100);

            case 'Trustway 360':
                return $amount + ($amount * 90/100);

            case 'Trustway Pension':
                return $this->getTrustwayPensionAmount($amount, $duration);

            default:
                return 0;
        }
    }

    public function store(Request $request)
    {
    	$wallet = $request->user()->wallet;

    	$validator = Validator::make($request->input(), [
            'investment-type' => [
            	'required', 
            	Rule::in(TrustwayInvestment::getInvestmentTypes())
            ],
            'amount' => [
            	'required', 
            	'numeric', 
            	'min:0', 
            	'max:'.$wallet->withdrawable , 
            	new InvestmentMinAndMaxAmount
            ],
            'duration' => [
            	'required_if:investment-type,Trustway Pension', 
            	'between:2,10', 
            	'integer'
            ]            
        ]);

        if ($validator->fails()) {
            return response()->json([
              'error' => $validator->errors(),
            ], 400);
        }


        $amount = (int) $request->amount;
        $duration = $request['duration'] ?? 0;
        $duration = (int) $duration;

        $investment = TrustwayInvestment::create([
        	'user_id' => $request->user()['id'],
        	'investment_amount' => $amount,
        	'investment_type' => $request['investment-type'],
        	'checkout_amount' => $this->getCheckoutAmount($request['investment-type'], $amount, $duration)
        ]);

        $wallet->withdrawable = $wallet->withdrawable - $amount;
        $wallet->save();

        Activity::create([
        	'user_id' => $request->user()['id'],
        	'detail' => "Created " . $request['investment-type'] . " investment with &#8358;" . $amount
        ]);

        if($request['investment-type'] == 'Trustway Pension'){
            TrustwayPensionInvestment::create([
                'trustway_investment_id' => $investment->id,
                'duration' => (string) $duration,
            ]);
        }

        return response()->json([
            'message' => 'Successfully created withdrawal request',
            'wallet' => $wallet,
            'investment' => $investment
        ], 200);
    }

}
