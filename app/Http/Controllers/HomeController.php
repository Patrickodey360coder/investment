<?php

namespace App\Http\Controllers;

use App\Wallet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wallet = Wallet::all()->where('user_id', Auth::user()['id'])->first();
        return view('home')->with('wallet', $wallet);
    }
}
