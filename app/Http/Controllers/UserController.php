<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Session;

require '../resources/countries.php';

class UserController extends Controller
{
    public function index()
    {
    	return view('profile')->with('activeLink', 'profile')->with('countries', Countries);
    }

    public function update(Request $request)
    {
    	$this->validate($request, [
            'name' => 'required|string|max:255',
            'country' => ['required', Rule::in(Countries)],
            'password' => 'required|string|min:8|confirmed',
        ]);
        $user = Auth::user();
    	$user->name = $request->name;
        $user->country = $request->country;
    	$user->password = bcrypt($request->password);
        $user->save();

        Session::flash('success','Profile saved.');
        return redirect()->route('profile');
    }

    public function showInvestors()
    {
    	return view('admin.investors')->with('investors', User::all()->where('role', 'user'))->with('activeLink', 'investor');
    }
}
