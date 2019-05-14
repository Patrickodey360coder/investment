<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    public function index()
    {
    	return view('user.activities')->with('activities', Auth::user()->activities)->with('activeLink', 'activities');
    }
}
