<?php

namespace App\Http\Controllers;

use App\TrustwayInvestment;
use App\Wallet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TrustwayInvestmentController extends Controller
{
    public function index()
    {
    	return view('user.trustway-investment');
    }

    public function createForm()
    {
    	$wallet = Wallet::all()->where('user_id', Auth::user()['id'])->first();
    	return view('user.create-trustway-investment')->with('investments', TrustwayInvestment::getInvestmentTypes())->with('wallet', $wallet);
    }
}
