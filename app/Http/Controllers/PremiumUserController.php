<?php

namespace App\Http\Controllers;

use App\Activity;
use App\BankAccount;
use App\User;
use App\Wallet;
use App\PremiumUser;
use App\Rules\ValidateDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class PremiumUserController extends Controller
{
    public function index()
    {
    	$minInvestmentDate = strftime("%Y-%m-%d 00:00:00", strtotime("-12 months 1 day"));
    	$maxInvestmentDate = strftime("%Y-%m-%d 00:00:00", strtotime("12 months"));

    	return view('admin.premium')->with('investors', User::all()->where('role', 'premium'))->with('activeLink', 'premium')->with('minInvestmentDate', $minInvestmentDate)->with('maxInvestmentDate', $maxInvestmentDate);
    }

    private function sendmail($subject,$message, $from, $to)
    {
        $message = wordwrap($message,70);
        
        // $to = "nobody@somedomain.com";
        // $from = "Sender Name <somebody@somedomain.com>";
        $headers = "From: {$from}\n";//you may need to use \r\n instead of \n for your line return
        $headers .= "Reply-To: {$from}\n";//if the recipient want to reply to this mail, this is the email address that the email will go to
        // $headers .= "Cc: {$to}\n";
        // $headers .= "Bcc: {$to}\n";
        // $headers .= "X-Mailer: PHP/".phpversion()."\n";
        $headers .= "MIME-Version: 1.0\n";
        $headers .= "Content-Type: text/html; charset=iso-8859-1";
        
        try {
            $result = mail($to, $subject, $message, $headers);
        } catch(Exception $error){

        }
    }

    private function genPassword(int $length, string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'): ?string
    {
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces []= $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }

    public function create(Request $request)
    {
    	$this->validate($request, [
            'email' => 'required|string|email|max:255|unique:users',
            'investment_amount' => 'required|numeric|min:1',
            'investment_date' => ['required', new ValidateDate],
            'months' => 'required|integer|min:1',
        ]);

        $password = $this->genPassword(8);
        
        $investment_date = strtotime($request->investment_date);

        $user = User::create([
        	'email'=> $request['email'],
        	'role' => 'Premium',
        	'password' => bcrypt($password)
        ]);

        Wallet::create([
            'user_id' => $user->id,
            'total_earnings' => 0,
            'balance' => 0,
            'withdrawable' => 0,
        ]);

        BankAccount::create([
            'user_id' => $user->id,
            'bank_name' => '',
            'account_name' => '',
            'account_number' => '',
        ]);

        PremiumUser::create([
        	'user_id' => $user->id,
        	'investment_amount' => $request['investment_amount'],
        	'months' => $request['months'],
        	'investment_date' => strftime("%Y-%m-%d %H:%M:%S", $investment_date),
        	'expiration_date' => strftime("%Y-%m-%d 00:00:00", strtotime('+1 months', $investment_date)),
        	'expiration_date' => strftime("%Y-%m-%d 00:00:00", strtotime('+' . $request['months'] .' months', $investment_date))
        ]);

		Activity::create([
            'user_id' => Auth::user()['id'],
            'detail' => "You add " . $request['email'] ." as a premium user"
        ]);

        Activity::create([
            'user_id' => $user->id,
            'detail' => "You were added a premium investment of &#8358;" . $request['investment_amount']
        ]);
        Session::flash('success', "Successfully created premium user");
        

        $MAINURL = "http://www.kidlever.com/";

        $message = file_get_contents(getcwd()."/../resources/views/email/newPremiumUser.html");

        $message = str_replace('%MAINURL%', $MAINURL, $message);
        $message = str_replace('%SITENAME%', 'Trustway Investment', $message);
        $message = str_replace('%EMAIL%', $request['email'], $message);
        $message = str_replace('%PASSWORD%', $password, $message);
        $message = str_replace('%LOGIN%', $MAINURL.'login/', $message);
        $message = str_replace('%ADDRESS%', "ADDRESS", $message);

        $from = "Adetola Olowolaju <adetola@trustwayinvestment.com>";
        $this->sendmail('You have been made a premium investor at Trustway Investment',$message, $from, $request['email']);

        return redirect()->back();
    }
}