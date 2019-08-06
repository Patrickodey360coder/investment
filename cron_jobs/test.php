<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our application. We just need to utilize it! We'll simply require it
| into the script here so that we don't have to worry about manual
| loading any of our classes later on. It feels great to relax.
|
*/

require __DIR__.'/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Turn On The Lights
|--------------------------------------------------------------------------
|
| We need to illuminate PHP development, so let us turn on the lights.
| This bootstraps the framework and gets it ready for use, then it
| will load up this application so that we can run it and send
| the responses back to the browser and delight our users.
|
*/

$app = require_once __DIR__.'/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request
| through the kernel, and send the associated response back to
| the client's browser allowing them to enjoy the creative
| and wonderful application we have prepared for them.
|
*/

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// $response->send();

$kernel->terminate($request, $response);

?>


<?php
	require "Database.php";
	use App\Activity;
	use App\PremiumUser;

	$now = strftime("%Y-%m-%d 00:00:00", time());
	$next_checkout_date = strftime("%Y-%m-%d 00:00:00", strtotime('+1 months', time()));
	$log = "Ran PremiumUser cron job at " . $now;

	$premium_users = PremiumUser::query()->where('next_checkout_date', '<=', $now)->where('expiration_date', '>=', $now)->get();

	$sql = "INSERT INTO logs (log) VALUES (?)";
	$smt = Database::$connection->prepare($sql);
	$smt->bindParam(1, $log);
	$smt->execute();

	foreach ($premium_users as $premium_user) {
		$user = $premium_user->user;

		$wallet = $user->wallet;

		$roiAmount = 10/100*$premium_user['investment_amount'];

		$wallet->balance += $roiAmount;
		$wallet->withdrawable += $roiAmount;
		$wallet->total_earnings += $roiAmount;
		$wallet->save();

		Activity::create([
            'user_id' => $user->id,
            'detail' => "You were paid &#8358;".$roiAmount." as ROI on your premium investment"
        ]);

        $premium_user['next_checkout_date'] = $next_checkout_date;
        $premium_user->save();
	}
?>