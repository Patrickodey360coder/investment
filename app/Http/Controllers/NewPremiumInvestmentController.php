<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class NewPremiumInvestmentController extends Controller
{
    public function index()
    {
    	$premiumUser = Auth::user()->premiumUser;
    	$canReinitiate = time() > strtotime($premiumUser->expiration_date);
    	return view('premium.reinitiateInvestment')->with('canReinitiate', $canReinitiate)->with('activeLink', 'reinitiateInvestment');
    }
}
