<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TrustwayInvestmentController extends Controller
{
    public function index(Request $request)
    {
    	return response()->json([
            'investments' => $request->user()->trustwayInvestments,
        ], 200);
    }
}
