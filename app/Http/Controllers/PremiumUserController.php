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

    public function addPayment(Request $request, $id)
    {
        $this->validate($request, [
            'amount' => ['required', 'numeric', 'min:0'],
            'months' => ['required', 'numeric', 'min:-12']
        ]);

        $premiumUser = PremiumUser::find($id);
        if(!empty($premiumUser)){
            $user = $premiumUser->user;

            $premiumUser->investment_amount += $request->amount;
            $premiumUser->months += $request->months;
            $next_checkout_date = strtotime($premiumUser->next_checkout_date);
            $expiration_date = strtotime($premiumUser->expiration_date);

            if($next_checkout_date < time()){
                $premiumUser->next_checkout_date = strftime("%Y-%m-%d 00:00:00", strtotime('+1 months', time()));
                $next_checkout_date = time();
            }

            $expiration_date = $expiration_date < time() ? time() : $expiration_date;

            $premiumUser->expiration_date = strftime("%Y-%m-%d 00:00:00", strtotime('+' . $request['months'] .' months', $expiration_date));
            $premiumUser->save();

            Activity::create([
                'user_id' => Auth::user()['id'],
                'detail' => "You topped up the premium investment of " . $user->name . "(" . $user->email . ")" . " with " . $request->amount . " and " . $request->months . " extra months"
            ]);

            Activity::create([
                'user_id' => $user->id,
                'detail' => "Your premium investment was topped up with " . $request->amount . " and " . $request->months . " extra months"
            ]);

            Session::flash('success', "Successfully added bonus to " . $user->name);
        } else {
            Session::flash('error', "Could not add the requested bonus");
        }

        return redirect()->back();
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

        BankAccount::create([
            'user_id' => $user->id,
            'bank_name' => '',
            'account_name' => '',
            'account_number' => '',
        ]);

        Activity::create([
            'user_id' => Auth::user()['id'],
            'detail' => "You add " . $request['email'] ." as a premium user"
        ]);

        Activity::create([
            'user_id' => $user->id,
            'detail' => "You were added a premium investment of &#8358;" . $request['investment_amount']
        ]);

        $last_investment_date = $investment_date;
        $total_earnings = 0;
        if(time() > $investment_date){
            $month = 1;
            $roiAmount = 10/100*$request['investment_amount'];
            while (time() > strtotime('+'.$month.' months', $investment_date)) {
                $last_investment_date = strtotime('+'.$month.' months', $investment_date);
                $month++;
                $total_earnings += $roiAmount;
                Activity::create([
                    'user_id' => $user->id,
                    'detail' => "You were paid &#8358;".$roiAmount." as ROI on your premium investment"
                ]);
            }
        }

        PremiumUser::create([
            'user_id' => $user->id,
            'investment_amount' => $request['investment_amount'],
            'months' => $request['months'],
            'investment_date' => strftime("%Y-%m-%d %H:%M:%S", $investment_date),
            'next_checkout_date' => strftime("%Y-%m-%d 00:00:00", strtotime('+1 months', $last_investment_date)),
            'expiration_date' => strftime("%Y-%m-%d 00:00:00", strtotime('+' . $request['months'] .' months', $investment_date))
        ]);

        Wallet::create([
            'user_id' => $user->id,
            'total_earnings' => $total_earnings,
            'balance' => 0,
            'bonus' => 0,
            'withdrawable' => 0,
        ]);

        Session::flash('success', "Successfully created premium user");
        

        // $MAINURL = "http://www.trustwaycapital.ng/";

        // $message = file_get_contents(getcwd()."/../resources/views/email/newPremiumUser.html");

        // $message = str_replace('%MAINURL%', $MAINURL, $message);
        // $message = str_replace('%SITENAME%', 'Trustway Capital', $message);
        // $message = str_replace('%EMAIL%', $request['email'], $message);
        // $message = str_replace('%PASSWORD%', $password, $message);
        // $message = str_replace('%LOGIN%', $MAINURL.'login/', $message);
        // $message = str_replace('%ADDRESS%', "ADDRESS", $message);

        // $from = "Adetola Olowolaju <adetola@trustwaycapital.ng>";
        // $this->sendmail('You have been made a premium investor at Trustway Investment',$message, $from, $request['email']);
        
        $result = array();
        //The parameter after verify/ is the transaction reference to be verified
        $password = $password;
        $email = $request['email'];
        $url = 'https://kidlever.com/sendmail/index.php?password='.$password; 
        $url .='&email='.$email;
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt(
    
        // $ch, CURLOPT_HTTPHEADER, [
        //     'Authorization: Bearer ' . PaystackPrivateKey]
        // );
        echo $url;
    
        $request = curl_exec($ch);
        if(curl_error($ch)){
            //echo 'error:' . curl_error($ch);
        }
    
        curl_close($ch);

        return redirect()->back();
    }
}