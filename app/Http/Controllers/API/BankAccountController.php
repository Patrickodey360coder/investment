<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BankAccountController extends Controller
{
    public function index(Request $request)
    {
    	return response()->json([
            'bank' => $request->user()->bankAccount,
        ], 200);
    }
}
