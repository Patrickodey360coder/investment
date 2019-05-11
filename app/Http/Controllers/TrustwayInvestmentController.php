<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrustwayInvestmentController extends Controller
{
    public function index()
    {
    	return view('user.trustway-investment');
    }
}
