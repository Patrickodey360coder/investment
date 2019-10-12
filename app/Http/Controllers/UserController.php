<?php

namespace App\Http\Controllers;

use App\Activity;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Hash;
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
            'phone' => 'required|string|max:20',
            'country' => ['required', Rule::in(Countries)],
            'password' => 'required|string|min:8|confirmed',
        ]);
        $user = Auth::user();
    	$user->name = $request->name;
        $user->country = $request->country;
        $user->phone = $request->phone;
    	$user->password = bcrypt($request->password);
        $user->save();

        Session::flash('success','Profile saved.');
        return redirect()->route('profile');
    }

    public function showInvestors()
    {
    	return view('admin.investors')->with('investors', User::all()->where('role', 'user'))->with('activeLink', 'investor');
    }

    public function forgotPassword(Request $request){
        $this->validate($request, [
          'email' => [
            'required',
            'email',
            'exists:users,email',
          ]
        ]);

        $user = User::where('email', '=', $_POST['email']??'')->first();

        if (empty($user)) {
            Session::flash('error', "Could not find user in our database");

            return redirect()->route('forgotPassword');
        }

        $password = $this->genPassword(8);
        // SEND EMAIL CONTAINING PASSWORD

        $user->password = Hash::make($password);
        $user->save();

        Activity::create([
            'user_id' => $user->id,
            'detail' => "Reset password"
        ]);

        $email = $user->email;
        $url = 'https://kidlever.com/sendmail/password.php?password='.$password; 
        $url .='&email='.$email;
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $request = curl_exec($ch);
        if(curl_error($ch)){
            //echo 'error:' . curl_error($ch);
        }
    
        curl_close($ch);

        Session::flash('success', "An email has been sent containing your new password");

        return redirect()->route('login');
    }

    private function genPassword(int $length, string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces []= $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }
}
