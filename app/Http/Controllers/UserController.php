<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class UserController extends Controller
{
    public function index()
    {
    	return view('profile')->with('activeLink', 'profile');
    }

    public function update(Request $request)
    {
    	$this->validate($request, [
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $user = Auth::user();
    	$user->name = $request->name;
    	$user->password = bcrypt($request->password);
        $user->save();

        Session::flash('success','Profile saved.');
        return redirect()->route('profile');
    }
}
