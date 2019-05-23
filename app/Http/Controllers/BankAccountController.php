<?php

namespace App\Http\Controllers;

use App\BankAccount;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankAccountController extends Controller
{
    public function index()
    {
    	return view('user.bank')->with('bank', Auth::user()->bankAccount)->with('activeLink', 'bank');
    }

    public function update(Request $request)
    {
    	$this->validate($request, [
            'bank_name' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|numeric|min:1'
        ]);
        $bank = Auth::user()->bankAccount;
        $bank['bank_name'] = $request->bank_name;
        $bank['account_name'] = $request->account_name;
        $bank['account_number'] = $request->account_number;
        $bank->save();

        Session::flash('success','Bank details saved.');
        return redirect()->route('user.bank');
    }
}
